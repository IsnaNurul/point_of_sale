<?php

namespace App\Livewire\Pos;

use App\Models\Bank;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Product;
use App\Models\SaleItem;
use App\Models\SaleTransaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormPayment extends Component
{
    public $totalCart = null;
    public $codeTransaction = null;
    public $bank;
    public $discount;
    public $discount_type = 'percent';
    public $rekening;
    public $carts;
    public $payment_method;
    public $payment_ammount;
    public $vouchers;
    public $voucherCode;
    public $cartId;
    public $qty;
    public $noted;
    public $price;
    public $salesId;
    public $customers;
    public $customer_name;

    public $showPaymentModal = true; // Modal pembayaran awal
    public $showSuccessModal = false; // Modal sukses
    public $addCartModal = false; // Modal sukses
    public $showInvoiceModal = false;
    public $changeAmount = 0; // Uang kembalian
    public $totalAmount = 0; // Uang kembalian
    public $saleItem = [];
    public $saleTransaction = [];

    protected $listeners = ['setTotalCart', 'addDiscount', 'showInvoice'];

    public function closeModal()
    {
        return redirect('pos');
    }

    public function setInvoice($codeTransaction)
    {
        $this->codeTransaction = $codeTransaction;
        $this->showInvoice();
    }

    public function showInvoice()
    {

        $this->saleTransaction = SaleTransaction::where('transaction_code', $this->codeTransaction)->first();
        $this->showPaymentModal = false;
        $this->showSuccessModal = false;
        $this->showInvoiceModal = true;
        $this->addCartModal = false;
        $id = SaleTransaction::where('transaction_code', $this->codeTransaction)->first();

        $this->saleItem = SaleItem::with('sale_transaction', 'product')->where('saleId', $id->id)
            ->get(); // Mengambil transaksi pertama (terbaru)

        $this->dispatch('showInvoice');
    }

    public function setTotalCart($totalCart)
    {
        $sales = SaleTransaction::find($totalCart);

        if ($sales && $sales->status === 'hold') {
            $this->salesId = $sales->id;
            $this->totalCart = $sales->total_price;
            $this->vouchers = Discount::where('status', 1)->get();
            $this->bank = Bank::all();
        } else {

            $this->totalCart = $totalCart;
            $lastTransaction = \App\Models\SaleTransaction::whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->first();

            // Check if $lastTransaction is null
            $this->codeTransaction = $lastTransaction ? $lastTransaction->transaction_code : null;

            $this->bank = Bank::all();
            $this->carts = Cart::where('cashierId', Auth::id())->get();
            $this->vouchers = Discount::where('status', 1)->get();

            $this->showPaymentModal = true;
            $this->showSuccessModal = false;
            $this->addCartModal = false;
            $this->showInvoiceModal = false;
        }

        $this->dispatch('totalCartUpdated', ['totalCart' => $totalCart]);
    }

    public function mount($totalCart = null, $codeTransaction = null)
    {
        $this->totalCart = $totalCart;
        $lastTransaction = \App\Models\SaleTransaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        // Check if $lastTransaction is null
        $this->codeTransaction = $lastTransaction ? $lastTransaction->transaction_code : null;

        $this->bank = Bank::all();
        $this->carts = Cart::where('cashierId', Auth::id())->get();
        $this->vouchers = Discount::where('status', 1)->get();
        $this->customers = User::where('role', 'customer')->get();
    }

    public function addDiscount($cartId)
    {
        $this->showPaymentModal = false;
        $this->showSuccessModal = false;
        $this->showInvoiceModal = false;
        $this->addCartModal = true;
        $this->cartId = $cartId;

        $cartItem = Cart::find($this->cartId);

        $this->discount = $cartItem->discount;
        $this->discount_type = $cartItem->discount_type ? 'fixed' : 'percent';
        $this->qty = $cartItem->qty;
        $this->noted = $cartItem->noted;
    }

    public function discountEdit($cartId)
    {
        $cart = Cart::find($cartId);

        $product = Product::find($cart->productId);

        if (!$product) {
            session()->flash('error', 'Product not found.');
            return;
        }

        // Validasi kuantitas
        if ($this->qty > $product->qty) {
            $this->addError('qty', 'Quantity exceeds available stock (' . $product->qty . ').');
            return;
        }

        $cart->price = $product->price * $this->qty;
        $cart->discount = $this->discount;
        $cart->discount_type = $this->discount_type;
        $cart->qty =  $this->qty;
        $cart->noted =  $this->noted;
        $cart->save();

        $this->addCartModal = false;
        $this->showPaymentModal = true;
        $this->showSuccessModal = false;
        $this->showInvoiceModal = false;
        return redirect('pos');
    }

    public function saveTransaction()
    {
        try {
            $sales = SaleTransaction::find($this->salesId);
            $customer = null;
            if ($sales) {
                if ($this->voucherCode) {
                    $voucher = Discount::where('id', $this->voucherCode)->first();
                    if (!$voucher) {
                        session()->flash('error', 'Voucher not found!');
                        return redirect('pos');
                    }

                    $transactionDiscount = 0;
                    if ($voucher->discount_type === 'percent') {
                        $transactionDiscount = intval(round(($voucher->value / 100) * $sales->total_price));
                    } elseif ($voucher->discount_type === 'fixed') {
                        $transactionDiscount = intval($voucher->value);
                    }
                } else {
                    $transactionDiscount = 0;
                    if ($this->discount_type === 'percent') {
                        $transactionDiscount = intval(round(($this->discount / 100) * $sales->total_price));
                    } elseif ($this->discount_type === 'fixed') {
                        $transactionDiscount = intval($this->discount);
                    }
                }

                // Total harga akhir
                $totalPrice = $sales->total_price - $transactionDiscount;

                if ($this->rekening === null) {
                    $payment_method = 'cash';
                    $payment_ammount = $this->totalCart;

                    if ($payment_ammount < $totalPrice) {
                        session()->flash('error', 'Payment failed, payment amount is less than total payment!');
                        return redirect('hold');
                    }
                } else {
                    $payment_method = 'debit';
                    $payment_ammount = $totalPrice;
                }

                if ($this->customer_name) {
                    $user = User::create([
                        'name' => $this->customer_name,
                        'role' => 'customer',
                    ]);

                    $customer = Customer::create([
                        'userId' => $user->id,
                        'adminId' => Auth::id()
                    ]);
                }

                $saleTransaction = SaleTransaction::where('id', $this->salesId)->first();
                // dd($transactionDiscount);
                // Simpan ke tabel sale_transactions
                $saleTransaction->update([
                    'discount' => $transactionDiscount,
                    'status' => 'success',
                    'total_price' => $totalPrice,
                    'payment_method' => $payment_method,
                    'rekening' => $this->rekening,
                    'payment_ammount' => $payment_ammount,
                    'cashierId' => Auth::id(),
                    'customer_name' => $this->customer_name ? $this->customer_name : '',
                    'customerId' => $customer ? $customer->id : null,
                ]);

                if ($saleTransaction) {
                    session()->flash('success', 'Transaction successfully created!');
                    return redirect('hold');
                }
            } else {
                $cartItems = Cart::where('cashierId', Auth::id())->get();

                if ($cartItems->isEmpty()) {
                    session()->flash('error', 'Cart is empty. Please add products to cart before payment.!');
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

                if ($this->voucherCode) {
                    $voucher = Discount::where('id', $this->voucherCode)->first();
                    if (!$voucher) {
                        session()->flash('error', 'Voucher not found!');
                        return redirect('pos');
                    }

                    $transactionDiscount = 0;
                    if ($voucher->discount_type === 'percent') {
                        $transactionDiscount = intval(round(($voucher->value / 100) * $totalAmountCart));
                    } elseif ($voucher->discount_type === 'fixed') {
                        $transactionDiscount = intval($voucher->value);
                    }
                } else {
                    $transactionDiscount = 0;
                    if ($this->discount_type === 'percent') {
                        $transactionDiscount = intval(round(($this->discount / 100) * $totalAmountCart));
                    } elseif ($this->discount_type === 'fixed') {
                        $transactionDiscount = intval($this->discount);
                    }
                }

                // Total harga akhir
                $totalPrice = $totalAmountCart - $transactionDiscount;

                // Ambil nomor urut terakhir untuk tanggal hari ini
                $lastTransaction = \App\Models\SaleTransaction::whereDate('created_at', now()->toDateString())
                    ->orderBy('id', 'desc')
                    ->first();


                if ($lastTransaction == null) {
                    // Format tanggal untuk kode transaksi
                    $today = now()->format('ymd');

                    // Buat kode transaksi baru untuk transaksi pertama hari ini
                    $formattedSequence = str_pad(1, 4, '0', STR_PAD_LEFT);
                    $transactionCode = $today . $formattedSequence;
                } else {
                    // Ambil tanggal hari ini dalam format YYMMDD
                    $today = now()->format('ymd');


                    // Tentukan nomor urut baru
                    $sequence = $lastTransaction ? intval(substr($lastTransaction->transaction_code, -4)) + 1 : 1;

                    // Format nomor urut menjadi 4 digit
                    $formattedSequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);

                    // Buat kode transaksi
                    $transactionCode = $today . $formattedSequence;
                }

                if ($this->rekening === null) {
                    $payment_method = 'cash';
                    $payment_ammount = $this->totalCart;

                    if ($payment_ammount < $totalPrice) {
                        session()->flash('error', 'Payment failed, payment amount is less than total payment!');
                        return redirect('pos');
                    }
                } else {
                    $payment_method = 'debit';
                    $payment_ammount = $totalPrice;
                }

                if ($this->customer_name) {
                    $user = User::create([
                        'name' => $this->customer_name,
                        'role' => 'customer',
                    ]);

                    $customer = Customer::create([
                        'userId' => $user->id,
                        'adminId' => Auth::id()
                    ]);
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
                    'customer_name' => $this->customer_name ? $this->customer_name : '',
                    'customerId' => $customer ? $customer->id : null,
                ]);

                // Simpan ke tabel sale_items
                foreach ($cartItems as $item) {
                    $product = Product::find($item->productId);

                    if (!$product) {
                        session()->flash('error', 'Product not found.');
                        return redirect('pos');
                    }

                    SaleItem::create([
                        'saleId' => $saleTransaction->id,
                        'productId' => $item->productId,
                        'qty' => $item->qty,
                        'price' => $item->price,
                        'discount' => $item->discount,
                        'discount_type' => $item->discount_type,
                    ]);

                    // Update product stock
                    $product = \App\Models\Product::find($item->product->id);
                    if ($product) {
                        $product->qty -= $item->qty;
                        if ($product->qty < 0) {
                            session()->flash('error', 'Insufficient stock for product: ' . $product->name);
                            return;
                        }
                        $product->save();
                    }
                }

                // Hapus data cart setelah transaksi
                Cart::where('cashierId', Auth::id())->delete();

                $this->changeAmount = $payment_ammount - $totalPrice;
                $this->totalAmount = $totalPrice;
                $this->codeTransaction = $saleTransaction->transaction_code;
                $this->showPaymentModal = false;
                $this->showSuccessModal = true;
                $this->addCartModal = false;
                $this->showInvoiceModal = false;
            }
        } catch (\Exception $e) {
            // Tangani error dan tampilkan pesan
            session()->flash('error', 'Transaction failed: ' . $e->getMessage());
            return redirect('pos');
        }
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
