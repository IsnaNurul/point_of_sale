<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product; // Pastikan model produk ada
use Illuminate\Support\Facades\Validator;

class FormProducts extends Component
{
    public $productId;
    public $sku, $name, $price, $qty, $description, $discount, $categoryId, $unitId, $image;

    protected $rules = [
        'sku' => 'required|unique:products,sku',
        'name' => 'required|string|max:255',
        'price' => 'required|integer|min:0',
        'qty' => 'required|integer|min:0',
        'description' => 'nullable|string|max:255',
        'discount' => 'nullable|integer|min:0|max:100',
        'categoryId' => 'nullable|exists:categories,id',
        'unitId' => 'nullable|exists:units,id',
        'image' => 'nullable|string', // Jika gambar diunggah, tambahkan logika penyimpanan
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $product = Product::find($productId);
            if ($product) {
                $this->productId = $product->id;
                $this->sku = $product->sku;
                $this->name = $product->name;
                $this->price = $product->price;
                $this->qty = $product->qty;
                $this->description = $product->description;
                $this->discount = $product->discount;
                $this->categoryId = $product->categoryId;
                $this->unitId = $product->unitId;
                $this->image = $product->image;
            }
        }
    }

    public function save()
    {
        $data = $this->validate();

        if ($this->productId) {
            // Update Product
            $product = Product::find($this->productId);
            $product->update($data);
            session()->flash('message', 'Product updated successfully.');
        } else {
            // Add New Product
            Product::create($data);
            session()->flash('message', 'Product added successfully.');
        }

        $this->reset();

    }

    public function render()
    {
        return view('livewire.products.form-products', [
            'categories' => \App\Models\Category::all(),
            'units' => \App\Models\Unit::all(),
        ]);
    }
}
