<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public $name;
    public $email;
    public $phone;
    public $address;
    public $username;
    public $password;

    public function mount()
    {
        $user = Auth::user();

        // Initialize the component properties with user data
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;  // Assuming there's a phone column in the users table
        $this->address = $user->address;  // Assuming there's an address column in the users table
        $this->username = $user->username;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        // Validate and update the user's data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8', // Password can be nullable
        ]);

        // Update user data
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'username' => $this->username,
            'password' => $this->password ? bcrypt($this->password) : $user->password, // Only update password if provided
        ]);

        // Optionally, show a success message or redirect
        session()->flash('success', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.profile.profile');
    }
}
