<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ListProducts extends Component
{
    public $products;

    public function mount()
    {
        $this->products = Product::with(['category', 'unit'])->get();
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->status == 1) {
                session()->flash('error', 'Product cannot be deleted because it is currently active.');
                return;
            }
            // Hapus gambar dari penyimpanan jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->delete();
            session()->flash('success', 'Product deleted successfully.');
            $this->refreshData();
        } else {
            session()->flash('error', 'Product not found.');
        }
    }

    public function refreshData()
    {
        $this->products = Product::with(['category', 'unit'])->get();
    }

    public function render()
    {
        return view('livewire.products.list-products');
    }
}
