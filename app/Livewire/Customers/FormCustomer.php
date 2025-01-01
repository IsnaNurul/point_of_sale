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
    public $username = '';
    public $role = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $password = '';

    protected $listeners = ['setCustomerData'];

    public function setCustomerData($customerId)
    {
        $this->customerId = $customerId;

        if ($customerId) {
            $user = User::find($customerId);
            if ($user) {
                $this->name = $user->name;
                $this->username = $user->username;
                $this->email = $user->email;
                $this->phone = $user->phone;
                $this->address = $user->address;
                // $this->password = $user->password;
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
                $this->username = $user->username;
                $this->email = $user->email;
                $this->phone = $user->phone;
                $this->address = $user->address;
                $this->password = $user->password;
            }
        }
    }

    public function saveCustomer()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'password' => $this->customerId ? 'nullable|min:6' : 'required|min:6',
        ]);

        if ($this->customerId) {
            $customer = User::find($this->customerId);
            if (!$customer) {
                session()->flash('error', 'Customer not found.');
                return;
            }
            $customer->update([
                'name' => $this->name,
                'username' => $this->username,
                'role' => 'customer',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'password' => $this->password ? bcrypt($this->password) : $customer->password,
            ]);

            session()->flash('success', 'Customer updated successfully!');
        } else {
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'role' => 'customer',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'password' => bcrypt($this->password),
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
