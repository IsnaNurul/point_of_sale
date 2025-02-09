<?php

namespace App\Livewire\Cashier;

use App\Models\Cashier;
use App\Models\User;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ListCashier extends Component
{
    public $cashiers;

    public function mount()
    {
        $this->cashiers = Cashier::with('user')->get();
    }
    public function deleteCashier($id)
    {
        try {
            Cashier::where('userId', $id)->delete();
            $user = User::where('id', $id)->first();

            if ($user) {
                $user->delete();
                $this->refreshCashier();
                session()->flash('success', 'Cashier deleted successfully!');
                return redirect('cashier');
            } else {
                session()->flash('error', 'Cashier not defined!');
                return redirect('cashier');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete customer because it is being used in other data.');
            return redirect('cashier');
        } else {
            session()->flash('error', 'An error occurred while deleting the customer.');
            return redirect('cashier');
        }
    }

    public function refreshCashier()
    {
        $this->cashiers = Cashier::with('user')->get();
    }
    public function render()
    {
        return view('livewire.cashier.list-cashier');
    }
}
