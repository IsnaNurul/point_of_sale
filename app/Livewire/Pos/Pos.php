<?php

namespace App\Livewire\Pos;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SaleTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public $products;
    public $carts;
    public $cartsCount;
    public $productInCart = [];
    public $discount;
    public $subTotalCart = 0;
    public $totalDiscount = 0;
    public $discountNominal = 0;
    public $totalCart = 0;
    public $transactionId = 0;
    public $holdCount = 0;

    public function mount()
    {
        $this->clearCartIfNewDay();
        $this->holdCount = SaleTransaction::where('status', 'hold')->get()->count();
        $this->products = Product::where('qty', '>', 0)->get();
        $this->updateCarts();
    }

    public function clearCartIfNewDay()
    {
        // Ambil tanggal sekarang
        $today = now()->toDateString();

        // Hapus item dari cart jika dibuat sebelum hari ini
        \App\Models\Cart::whereDate('created_at', '<', $today)->delete();
    }


    public function closeModal()
    {
        $this->updateCarts();
    }

    public function addToCart($productId)
    {
        $product = Product::find($productId);

        if (!$product) {
            session()->flash('error', 'Produk tidak ditemukan.');
            return;
        }

        $cart = Cart::where('productId', $productId)
            ->where('cashierId', Auth::id())
            ->first();

        if (!$cart) {

            Cart::create([
                'cashierId' => Auth::id(),
                'productId' => $productId,
                'qty' => 1,
                'price' => $product->price,
            ]);
        } else {
            $cart->increment('qty');
            $cart->update(['price' => $product->price * $cart->qty]);
        }

        $this->updateCarts();
    }

    public function increaseQty($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $product = Product::find($cart->productId);

            // Periksa apakah kuantitas di keranjang sudah mencapai stok produk
            if ($cart->qty >= $product->qty) {
                session()->flash('error', 'Quantity has reached maximum stock for the product: ' . $product->name);
                return redirect()->back();
            } else {
                $cart->increment('qty');
                $cart->update(['price' => $product->price * $cart->qty]);
                $this->updateCarts();
                $this->triggerEvent();
            }

        }
    }


    public function decreaseQty($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            if ($cart->qty > 1) {
                $cart->decrement('qty');
                $cart->update(['price' => $cart->product->price * $cart->qty]);
            } else {
                $cart->delete();
            }
            $this->updateCarts();
        }
    }

    public function deleteCartItem($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $cart->delete();
            $this->updateCarts();
            session()->flash('success', 'Produk berhasil dihapus dari keranjang.');
        } else {
            session()->flash('error', 'Produk tidak ditemukan di keranjang.');
        }
    }

    public function clearCart()
    {
        // Delete all cart items associated with the logged-in cashier
        Cart::where('cashierId', Auth::id())->delete();

        // Update the cart data after deletion
        $this->updateCarts();

        // Optionally, you can add a success message
        session()->flash('success', 'Semua produk berhasil dihapus dari keranjang.');
    }

    public function discountEdit($cart)
    {
        $this->discount = $cart['discount'];
        $this->dispatch('show-modal');
    }

    public function updateCarts()
    {
        $this->holdCount = SaleTransaction::where('status', 'hold')->get()->count();
        $this->carts = Cart::where('cashierId', Auth::id())->get();
        $this->cartsCount = Cart::where('cashierId', Auth::id())->get()->count();
        $this->productInCart = $this->carts->pluck('productId')->toArray();
        $this->subTotalCart = $this->carts->sum('price');

        $cartDiscounts = $this->carts->map(function ($item) {
            if ($item->discount_type === 'percent') {
                return intval(round(($item->discount / 100) * $item->price));
            } elseif ($item->discount_type === 'fixed') {
                return intval($item->discount);
            }
            return 0;
        });
        $this->totalDiscount = $cartDiscounts->sum();
        $this->totalCart = $this->subTotalCart - $this->totalDiscount;
        $today = now()->format('ymd');

        // Ambil transaksi terakhir untuk hari ini
        $lastTransaction = SaleTransaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransaction === null) {
            // Tidak ada transaksi hari ini, mulai dari 0001
            $formattedSequence = str_pad(1, 4, '0', STR_PAD_LEFT);
        } else {
            // Ambil nomor urut terakhir dan tambahkan 1
            $sequence = intval(substr($lastTransaction->transaction_code, -4)) + 1;
            $formattedSequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        }

        // Buat kode transaksi baru
        $transactionCode = $today . $formattedSequence;

        // Simpan kode transaksi baru ke properti
        $this->transactionId = (object) ['transaction_code' => $transactionCode];



        foreach ($this->carts as $cart) {
            if ($cart->discount > 0 && $cart->discount <= 100) {
                $cart->discountNominal = round($cart->price * ($cart->discount / 100));
            } else {
                $cart->discountNominal = $cart->discount;
            }
        }
    }

    public function getDiscountNominalAttribute()
    {
        if ($this->discount > 0 && $this->discount < 100) {
            return round($this->cart * ($this->discount / 100));
        }
        return $this->discount;
    }

    public function holdOrder()
    {
        if (count($this->carts) === 0) {
            session()->flash('error', 'Cart is empty. Please add products to cart before holding.');
            return;
        }

        // Ambil tanggal hari ini dalam format YYMMDD
        $today = now()->format('ymd');

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

        // Calculate totals
        $subTotal = $this->subTotalCart;
        $totalDiscount = $this->totalDiscount;
        $totalPrice = $subTotal - $totalDiscount;

        // Save to sale_transactions table
        $saleTransaction = \App\Models\SaleTransaction::create([
            'transaction_code' => $transactionCode,
            'total_qty' => $this->carts->sum('qty'),
            'total_price' => $totalPrice,
            'sub_total' => $subTotal,
            'discount' => $totalDiscount,
            'status' => 'hold', // Status is set to hold
            'payment_method' => null, // No payment method for hold
            'discountId' => null, // Adjust if applicable
            'customerId' => null, // Adjust if applicable
            'cashierId' => Auth::id(), // Set the current logged-in cashier
        ]);

        // dd($saleTransaction);

        // Save each cart item to sale_items table
        foreach ($this->carts as $cart) {
            \App\Models\SaleItem::create([
                'saleId' => $saleTransaction->id,
                'productId' => $cart->product->id,
                'qty' => $cart->qty,
                'price' => $cart->price,
            ]);

            // Update product stock
            $product = \App\Models\Product::find($cart->product->id);
            if ($product) {
                $product->qty -= $cart->qty;
                if ($product->qty < 0) {
                    session()->flash('error', 'Insufficient stock for product: ' . $product->name);
                    return;
                }
                $product->save();
            }
        }

        // Clear cart
        $this->clearCart();

        session()->flash('success', 'Order successfully held.');
    }

    public function triggerEvent()
    {
        $this->dispatch('feather-update', [
            'message' => 'Event triggered!',
        ]);
    }

    public function render()
    {
        return view('livewire.pos.pos');
    }
}
