<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormSuppliers extends Component
{
    public $supplierId = null;
    public $name = '';
    public $username = '';
    public $role = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $password = '';

    protected $listeners = ['setSupplierData'];

    public function setSupplierData($supplierId)
    {
        $this->supplierId = $supplierId;

        if ($supplierId) {
            $user = User::find($supplierId);
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

    public function mount($supplierId = null)
    {
        if ($supplierId) {
            $this->supplierId = $supplierId;
        } elseif ($this->supplierId) {
            $user = user::find($this->supplierId);
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

    public function saveSupplier()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'password' => $this->supplierId ? 'nullable|min:6' : 'required|min:6',
        ]);

        if ($this->supplierId) {
            $supplier = User::find($this->supplierId);
            if (!$supplier) {
                session()->flash('error', 'Supplier not found.');
                return;
            }
            $supplier->update([
                'name' => $this->name,
                'username' => $this->username,
                'role' => 'supplier',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'password' => $this->password ? bcrypt($this->password) : $supplier->password,
            ]);

            session()->flash('success', 'Supplier updated successfully!');
        } else {
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'role' => 'supplier',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'password' => bcrypt($this->password),
            ]);

            Supplier::create([
                'userId' => $user->id,
                'adminId' => Auth::user()->id,
            ]);

            session()->flash('success', 'Supplier created successfully!');
        }

        return redirect('suppliers');
    }
    public function render()
    {
        return view('livewire.suppliers.form-suppliers');
    }
}
