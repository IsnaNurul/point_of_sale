<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use App\Models\SaleTransaction;
use Livewire\Component;

class HoldPos extends Component
{
    public $holdId;
    public $products;
    public $search;
    public $noProductsFound = false;
    public $holdCount = 0;
    public $carts = [];

    public function mount($saleId = null, $search = null) // Optional parameter
    {

        $this->holdId = $saleId;
        $this->holdCount = SaleTransaction::where('status', 'hold')->count();

        $this->products = Product::where('qty', '>', 0)
            ->when($search, function ($query, $search) {
                // Cek apakah yang dicari adalah angka (harga)
                if (is_numeric($search)) {
                    $query->where('price', '=', $search); // Pencarian berdasarkan harga
                } else {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('category', 'like', "%$search%");
                        });
                }
            })
            ->get()
            ->map(function ($product) use ($saleId) {
                // Periksa apakah produk ada di sale_item
                $product->is_active = SaleTransaction::where('id', $saleId)
                    ->whereHas('sale_item', function ($query) use ($product) {
                        $query->where('productId', $product->id);
                    })
                    ->exists();
                return $product;
            });

        $this->noProductsFound = $this->products->isEmpty(); // Mengecek apakah produk kosong
        $this->carts =  SaleTransaction::with('sale_item')->where('id', $saleId)->first();
        
    }

    public function updatedSearch()
    {
        $this->products = Product::where('qty', '>', 0)
            ->when($this->search, function ($query, $search) {
                // Cek apakah yang dicari adalah angka (harga)
                if (is_numeric($search)) {
                    $query->where('price', '=', $search); // Pencarian berdasarkan harga
                } else {
                    $query->where('name', 'like', "%$search%")
                        ->orWhereHas('category', function ($q) use ($search) {
                            $q->where('category', 'like', "%$search%");
                        });
               }
            })
            ->get();

        $this->noProductsFound = $this->products->isEmpty();

    }

    public function render()
    {
        return view('livewire.pos.hold-pos');
    }
}
