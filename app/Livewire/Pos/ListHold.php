<?php

namespace App\Livewire\Pos;

use App\Models\SaleTransaction;
use Livewire\Component;

class ListHold extends Component
{
    public $holdCount = 0;
    public $holds;

    public function mount()
    {
        // Fetch holds from the database
        $this->holds = SaleTransaction::where('status', 'hold')->get();
        $this->holdCount = $this->holds->count();
        $this->updateData();
    }

    // public function test()
    // {
    //     dd('test');
    // }

    public function cancelTransaction($transactionId)
    {
        dd($transactionId);
        $transaction = SaleTransaction::find($transactionId);

        if ($transaction) {
            $transaction->status = 'canceled'; // Change the status
            $transaction->save(); // Save the updated record

            $this->holdCount = $this->holds->count();

            $this->updateData();
            // You can also add a success message or event here if needed
            session()->flash('message', 'Transaction canceled successfully.');
            return;
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
