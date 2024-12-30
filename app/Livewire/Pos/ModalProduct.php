<?php

namespace App\Livewire\Pos;

use App\Models\SaleItem;
use Livewire\Component;

class ModalProduct extends Component
{
    public $products = [];

    protected $listeners = ['setProductModal'];

    public function setProductModal($SaleId)
    {
        $this->products = SaleItem::where('saleId', $SaleId)
            ->with('product')
            ->get();
    }


    public function render()
    {
        return view('livewire.pos.modal-product');
    }
}
