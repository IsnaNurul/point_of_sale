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

    public function mount()
    {
        $this->products = Product::all();
        $this->updateCarts();
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
            $cart->increment('qty');
            $cart->update(['price' => $cart->product->price * $cart->qty]);
            $this->updateCarts();
            $this->triggerEvent();
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
        $this->carts = Cart::where('cashierId', Auth::id())->get();
        $this->cartsCount = Cart::where('cashierId', Auth::id())->get()->count();
        $this->productInCart = $this->carts->pluck('productId')->toArray();
        $this->subTotalCart = $this->carts->sum('price');
        $this->totalDiscount = $this->carts->sum('discount');
        $this->totalCart = $this->subTotalCart - $this->totalDiscount;
        $this->transactionId = SaleTransaction::whereDate('created_at', now()->toDateString())
            ->orderBy('id', 'desc')
            ->first();

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

        // Tentukan nomor urut baru
        $sequence = $lastTransaction ? intval(substr($lastTransaction->transaction_code, -4)) + 1 : 1;

        // Format nomor urut menjadi 4 digit
        $formattedSequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // Buat kode transaksi
        $transactionCode = $today . $formattedSequence;

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
