<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ListCustomer extends Component
{
    public $customers;

    public function mount()
    {
        $this->customers = Customer::with('user')->get();
    }
    public function deleteCustomer($id)
    {
        try {
            Customer::where('userId', $id)->delete();
            $user = User::where('id', $id)->first();

            if ($user) {
                $user->delete();
                $this->refreshCustomer();
                session()->flash('success', 'Customer deleted successfully!');
                return redirect('customers');
            } else {
                session()->flash('error', 'Customer not defined!');
                return redirect('customers');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete customer because it is being used in other data.');
        } else {
            session()->flash('error', 'An error occurred while deleting the customer.');
        }
    }

    public function refreshCustomer()
    {
        $this->customers = Customer::with('user')->get();
    }
    public function render()
    {
        return view('livewire.customers.list-customer');
    }
}
