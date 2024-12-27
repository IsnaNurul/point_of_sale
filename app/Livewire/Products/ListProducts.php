<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ListProducts extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::with(['category', 'unit'])->get();
    }

    public function render()
    {
        return view('livewire.products.list-products');
    }
}
