<?php

namespace App\Livewire\Pos;

use App\Models\SaleTransaction;
use Livewire\Component;

class ListTransaction extends Component
{
    public $holdCount = 0;
    public $holds;
    public $sales;

    public function mount()
    {
        $this->updateData();
    }

    public function updateData()
    {
        $this->holds = SaleTransaction::where('status', 'hold')->get();
        $this->holdCount = $this->holds->count();
        $this->sales = SaleTransaction::with('sale_item')->get();
    }

    public function render()
    {
        return view('livewire.pos.list-transaction');
    }
}
