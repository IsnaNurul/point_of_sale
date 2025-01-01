<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ListSuppliers extends Component
{
    public $suppliers;

    public function mount()
    {
        $this->suppliers = Supplier::with('user')->get();
    }
    public function deleteSupplier($id)
    {
        try {
            Supplier::where('userId', $id)->delete();
            $user = User::where('id', $id)->first();

            if ($user) {
                $user->delete();
                $this->refreshSupplier();
                session()->flash('success', 'Supplier deleted successfully!');
            } else {
                session()->flash('error', 'Supplier not defined!');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete supplier because it is being used in other data.');
        } else {
            session()->flash('error', 'An error occurred while deleting the supplier.');
        }
    }

    public function refreshSupliier()
    {
        $this->suppliers = Supplier::with('user')->get();
    }
    public function render()
    {
        return view('livewire.suppliers.list-suppliers');
    }
}
