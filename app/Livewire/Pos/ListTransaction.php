<?php

namespace App\Livewire\Pos;

use App\Models\SaleTransaction;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Models\Bank;

class ListTransaction extends Component
{
    public $holdCount = 0;
    public $holds;
    public $sales;
    public $rekening;

    public function mount()
    {
        $this->updateData();
    }

    public function updateData()
    {
        $this->holds = SaleTransaction::where('status', 'hold')->get();
        $this->holdCount = $this->holds->count();
        $this->sales = SaleTransaction::with('sale_item', 'user')->orderBy('created_at', 'desc')->get();

        // Loop untuk menambahkan nama bank
        foreach ($this->sales as $sale) {
            $bank = Bank::where('rekening', $sale->rekening)->first();
            // dd($bank);
            $sale->bank_name = $bank ? $bank->bank_name : 'Bank Tidak Ditemukan';
        }
    }

    public function exportToExcel()
    {
        return Excel::download(new SalesExport, 'sales_transactions.xlsx');
    }

    public function render()
    {
        return view('livewire.pos.list-transaction');
    }
}
