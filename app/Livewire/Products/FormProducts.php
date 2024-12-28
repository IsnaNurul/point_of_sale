<?php

namespace App\Livewire\Products;

use App\Models\Category;
use Livewire\Component;
use App\Models\Product; // Pastikan model produk ada
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class FormProducts extends Component
{
    use WithFileUploads;
    public $productId;
    public $sku, $status, $name, $price, $qty, $description, $categoryId, $unitId, $image;
    public $existingImage;

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
                $this->status = $product->status;
                $this->categoryId = $product->categoryId;
                $this->unitId = $product->unitId;
                $this->existingImage = $product->image;
            }
        }
    }

    public function save()
    {
        $rules = [
            'sku' => 'required|unique:products,sku,' . $this->productId,
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'qty' => 'required|integer|min:0',
            'description' => 'nullable|string|max:255',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'categoryId' => 'required',
            'unitId' => 'required',
        ];

        $data = $this->validate($rules);
        $data['userId'] = Auth::id();

        if ($this->image) {
            // Hapus gambar lama jika ada
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }

            // Simpan gambar baru
            $imagePath = $this->image->store('products', 'public');
            $data['image'] = $imagePath;
        } else if ($this->existingImage) {
            // Pertahankan gambar lama jika tidak ada gambar baru
            $data['image'] = $this->existingImage;
        }

        if ($this->image) {
            $imagePath = $this->image->store('products', 'public'); // Simpan gambar baru
            $data['image'] = $imagePath;
        } else if ($this->existingImage) {
            $data['image'] = $this->existingImage; // Pertahankan gambar lama
        }

        if ($this->productId) {
            // Update Produk
            $product = Product::find($this->productId);
            $product->update($data);
            session()->flash('message', 'Product updated successfully.');
        } else {
            // Tambah Produk Baru
            Product::create($data);
            session()->flash('message', 'Product added successfully.');
        }

        $this->reset();
        return redirect('products');
    }


    public function removeImage()
    {
        if ($this->productId && $this->existingImage) {
            // Hapus gambar dari storage
            Storage::disk('public')->delete($this->existingImage);
            $this->existingImage = null;
        }

        // Jika gambar baru diunggah
        if ($this->image) {
            $this->image = null;
        }

        session()->flash('message', 'Image removed successfully.');
    }


    public function render()
    {
        return view('livewire.products.form-products', [
            'categories' => Category::where('status', 'Active')->get(),
            'units' => Unit::where('status', 1)->get(),
        ]);
    }
}
