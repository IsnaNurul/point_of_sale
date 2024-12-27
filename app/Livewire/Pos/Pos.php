<?php

namespace App\Livewire\Pos;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public $products;
    public $carts;
    public $cartsCount;
    public $productInCart = [];
    public $discount;

    public function mount()
    {
        $this->products = Product::all();
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
