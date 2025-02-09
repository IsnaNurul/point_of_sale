<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormCustomer extends Component
{
    public $customerId = null;
    public $name = '';
    public $role = '';
    public $email = '';
    public $phone = '';
    public $address = '';

    protected $listeners = ['setCustomerData'];

    public function setCustomerData($customerId)
    {
        $this->customerId = $customerId;

        if ($customerId) {
            $user = User::find($customerId);
            if ($user) {
                $this->name = $user->name;
                $this->email = $user->email;
                $this->phone = $user->phone;
                $this->address = $user->address;
            }
        }
    }

    public function mount($customerId = null)
    {
        if ($customerId) {
            $this->customerId = $customerId;
        } elseif ($this->customerId) {
            $user = user::find($this->customerId);
            if ($user) {
                $this->name = $user->name;
                $this->email = $user->email;
                $this->phone = $user->phone;
                $this->address = $user->address;
            }
        }
    }

    public function saveCustomer()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);

        if ($this->customerId) {
            $customer = User::find($this->customerId);
            if (!$customer) {
                session()->flash('error', 'Customer not found.');
                return;
            }
            $customer->update([
                'name' => $this->name,
                'role' => 'customer',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            session()->flash('success', 'Customer updated successfully!');
        } else {
            $user = User::create([
                'name' => $this->name,
                'role' => 'customer',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
            ]);

            Customer::create([
                'userId' => $user->id,
                'adminId' => Auth::user()->id,
            ]);

            session()->flash('success', 'Customer created successfully!');
        }

        return redirect('customers');
    }

    public function render()
    {
        return view('livewire.customers.form-customer');
    }
}
