<?php

namespace App\Livewire\Cashier;

use App\Models\Cashier;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FormCashier extends Component
{
    public $cashierId = null;
    public $name = '';
    public $username = '';
    public $role = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $password = '';

    protected $listeners = ['setcashierData'];

    public function setcashierData($cashierId)
    {
        $this->cashierId = $cashierId;

        if ($cashierId) {
            $user = User::find($cashierId);
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

    public function mount($cashierId = null)
    {
        if ($cashierId) {
            $this->cashierId = $cashierId;
        } elseif ($this->cashierId) {
            $user = user::find($this->cashierId);
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

    public function saveCashier()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => $this->cashierId
                ? 'required|string|max:255|unique:users,username,' . $this->cashierId
                : 'required|string|max:255|unique:users,username',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'password' => $this->cashierId ? 'nullable|min:6' : 'required|min:6',
        ]);

        if ($this->cashierId) {
            $cashier = User::find($this->cashierId);
            if (!$cashier) {
                session()->flash('error', 'cashier not found.');
                return;
            }
            $cashier->update([
                'name' => $this->name,
                'username' => $this->username,
                'role' => 'cashier',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'password' => $this->password ? bcrypt($this->password) : $cashier->password,
            ]);

            session()->flash('success', 'cashier updated successfully!');
        } else {
            $user = User::create([
                'name' => $this->name,
                'username' => $this->username,
                'role' => 'cashier',
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'password' => bcrypt($this->password),
            ]);

            Cashier::create([
                'userId' => $user->id,
                'adminId' => Auth::user()->id,
            ]);

            session()->flash('success', 'cashier created successfully!');
        }

        return redirect('cashier');
    }

    public function render()
    {
        return view('livewire.cashier.form-cashier');
    }
}
