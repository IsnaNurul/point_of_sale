<?php

namespace App\Livewire\Pos;

use App\Models\Bank;
use App\Models\Cart;
use App\Models\SaleItem;
use App\Models\SaleTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPayment extends Component
{
    public $totalCart = null;
    public $codeTransaction = null;
    public $bank;
    public $discount;
    public $discount_type;
    public $rekening;
    public $carts;
    public $payment_method;
    public $payment_ammount;

    public $showPaymentModal = true; // Modal pembayaran awal
    public $showSuccessModal = false; // Modal sukses
    public $changeAmount = 0; // Uang kembalian
    public $totalAmount = 0; // Uang kembalian

    protected $listeners = ['setTotalCart'];

    public function setTotalCart($totalCart)
    {
        $this->totalCart = $totalCart;
        $lastTransaction = \App\Models\SaleTransaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        $this->codeTransaction = $lastTransaction->transaction_code;
        $this->bank = Bank::all();
        $this->dispatch('totalCartUpdated', ['totalCart' => $totalCart]);
        $this->carts = Cart::where('cashierId', Auth::id())->get();
    }

    public function mount($totalCart = null, $codeTransaction = null)
    {
        $this->totalCart = $totalCart;
        $lastTransaction = \App\Models\SaleTransaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        $this->codeTransaction = $lastTransaction->transaction_code;
        $this->bank = Bank::all();
        $this->carts = Cart::where('cashierId', Auth::id())->get();
    }

    public function saveTransaction()
    {
        $cartItems = Cart::where('cashierId', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Cart is empty!');
            return redirect('pos');
        }

        // Hitung subtotal dari cart
        $subTotal = $cartItems->sum('price');

        // Hitung diskon dari cart tanpa desimal
        $cartDiscounts = $cartItems->map(function ($item) {
            if ($item->discount_type === 'percent') {
                return intval(round(($item->discount / 100) * $item->price));
            } elseif ($item->discount_type === 'fixed') {
                return intval($item->discount);
            }
            return 0;
        });

        $totalAmountCart = $subTotal - $cartDiscounts->sum();

        // Hitung diskon saat transaksi
        $transactionDiscount = 0;
        if ($this->discount_type === 'percent') {
            $transactionDiscount = intval(round(($this->discount / 100) * $totalAmountCart));
        } elseif ($this->discount_type === 'fixed') {
            $transactionDiscount = intval($this->discount);
        }

        // Total harga akhir
        $totalPrice = $totalAmountCart - $transactionDiscount;

        // Ambil tanggal hari ini dalam format YYMMDD
        $today = now()->format('ymd');

        // Ambil nomor urut terakhir untuk tanggal hari ini
        $lastTransaction = \App\Models\SaleTransaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        // Tentukan nomor urut baru
        $sequence = $lastTransaction ? intval(substr($lastTransaction->transaction_code, -4)) + 1 : 1;

        // Format nomor urut menjadi 4 digit
        $formattedSequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Buat kode transaksi
        $transactionCode = $today . $formattedSequence;

        if ($this->rekening === null) {
            $payment_method = 'cash';
            $payment_ammount = $this->totalCart;
        } else {
            $payment_method = 'debit';
            $payment_ammount = $totalPrice;
        }

        // Simpan ke tabel sale_transactions
        $saleTransaction = SaleTransaction::create([
            'transaction_code' => $transactionCode,
            'total_qty' => $cartItems->sum('qty'),
            'total_price' => $totalPrice,
            'sub_total' => $totalAmountCart,
            'discount' => $transactionDiscount,
            'status' => 'success',
            'payment_method' => $payment_method,
            'rekening' => $this->rekening,
            'payment_ammount' => $payment_ammount,
            'cashierId' => Auth::id(),
        ]);

        // Simpan ke tabel sale_items
        foreach ($cartItems as $item) {
            SaleItem::create([
                'saleId' => $saleTransaction->id,
                'productId' => $item->productId,
                'qty' => $item->qty,
                'price' => $item->price,
                'discount' => $item->discount,
                'discount_type' => $item->discount_type,
            ]);
        }

        // Hapus data cart setelah transaksi
        Cart::where('cashierId', Auth::id())->delete();

        $this->changeAmount = $payment_ammount - $totalPrice;
        $this->totalAmount = $totalPrice;
        $this->codeTransaction = $saleTransaction->transaction_code;
        $this->showPaymentModal = false;
        $this->showSuccessModal = true;

    }

    public function nextOrder()
    {
        return redirect('pos');
    }

    public function render()
    {
        return view('livewire.pos.form-payment');
    }
}
