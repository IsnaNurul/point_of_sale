<?php

namespace App\Livewire\Bank;

use App\Models\Bank;
use Livewire\Component;

class ListBank extends Component
{
    public $bank;

    public function mount()
    {
        $this->bank = Bank::all();
    }

    public function deletebank($id)
    {
        try {
            // Cari kategori berdasarkan ID
            $bank = Bank::findOrFail($id);

            if ($bank) {
                if ($bank->status === 'Active') {
                    session()->flash('error', 'bank cannot be deleted because it is currently active.');
                    return redirect('bank');
                }
                $bank->delete();
                $this->refreshbank();
                session()->flash('success', 'bank deleted successfully!');
                return redirect('payment_method');
            } else {
                session()->flash('error', 'bank not defined!');
                return redirect('payment_method');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete bank because it is being used in other data.');
        } else {
            session()->flash('error', 'An error occurred while deleting the bank.');
        }
    }

    public function refreshbank()
    {
        $this->bank = bank::all();
    }

    public function render()
    {
        return view('livewire.bank.list-bank');
    }
}
