<?php

namespace App\Livewire\Pos;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormDiscount extends Component
{
    public $cart_id, $discount;
    public $discountType = null;

    public function mount($cartId)
    {
        $cart = Cart::find($cartId);

        $this->cart_id = $cart->id;
        $this->discount = $cart->discount;
    }

    public function discountUpdate()
    {
        $cart = Cart::find($this->cart_id);
        $cart->discount = $this->discount;
        $cart->save();

        return redirect('pos');
    }

    public function toggleDiscountType()
    {
        $this->discountType = $this->discountType === 'percent' ? 'rp' : 'percent';
    }

    public function render()
    {
        return view('livewire.pos.form-discount');
    }
}
