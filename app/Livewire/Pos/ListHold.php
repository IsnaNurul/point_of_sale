<?php

namespace App\Livewire\Pos;

use App\Models\SaleTransaction;
use Livewire\Component;

class ListHold extends Component
{
    public $holdCount = 0;
    public $holds;
    public $transaction;

    protected $listeners = ['setCancel'];

    public function mount()
    {
        // Fetch holds from the database
        $this->holds = SaleTransaction::where('status', 'hold')->orderBy('transaction_code', 'desc')->get();
        $this->holdCount = $this->holds->count();
        $this->updateData();
    }


    public function setCancel($SaleId)
    {
        $transaction = SaleTransaction::find($SaleId);

        if ($transaction) {
            $transaction->status = 'canceled'; // Ubah status
            $transaction->save(); // Simpan perubahan

            $this->updateData(); // Perbarui data
            session()->flash('success', 'Transaction successfully canceled!');
            return redirect('hold');
        } else {
            session()->flash('error', 'Transaction not found!');
            return redirect('hold');
        }
    }



    public function updateData()
    {
        $this->holds = SaleTransaction::where('status', 'hold')->get();
        $this->holdCount = $this->holds->count();
    }

    public function render()
    {
        return view('livewire.pos.list-hold');
    }
}
