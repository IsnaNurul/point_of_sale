<?php

namespace App\Livewire\Pos;

use App\Models\SaleItem;
use App\Models\SaleTransaction;
use Livewire\Component;

class ModalProduct extends Component
{
    public $saleItems = [];
    public $sales;
    public $items = [];

    protected $listeners = ['setProductModal'];

    public function setProductModal($SaleId)
    {
        $this->sales = SaleTransaction::where('id', $SaleId)->with('user')->first();
        
        $this->saleItems = SaleItem::where('saleId', $SaleId)->with('product')->get();

        // Initialize variables to store the total subTotal and discount
        $totalDiscount = 0;
        $subTotal = 0;

        foreach ($this->saleItems as $saleItem) {
            // Calculate discount for each sale item
            if ($saleItem->discount_type === 'percent') {
                $saleItem->discountNominal = round($saleItem->price * ($saleItem->discount / 100));
            } else {
                $saleItem->discountNominal = $saleItem->discount;
            }

            // Add to the total discount and subTotal
            $totalDiscount += $saleItem->discountNominal;
            $subTotal += $saleItem->price;
        }

        // Calculate grand total after discount
        $grandTotal = $subTotal - $totalDiscount;

        // Pass calculated totals to the component's items array
        $this->items = [
            'subTotal' => $subTotal,
            'totalDiscount' => $totalDiscount,
            'grandTotal' => $grandTotal,
        ];
    }


    public function render()
    {
        return view('livewire.pos.modal-product');
    }
}
