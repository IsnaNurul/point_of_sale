<?php

namespace App\Livewire\Bank;

use App\Models\Bank;
use Livewire\Component;

class FormBank extends Component
{
    public $bankId = null;
    public $bank_name = '';  // Change here to match validation
    public $rekening = '';
    public $bank;

    protected $listeners = ['setbankData'];

    public function setbankData($bankId)
    {
        $this->bankId = $bankId;

        if ($bankId) {
            $bank = Bank::find($bankId);
            if ($bank) {
                $this->bank_name = $bank->bank_name;  // Ensure this matches
                $this->rekening = $bank->rekening;
            }
        }
    }

    public function mount($bankId = null)
    {
        if ($bankId) {
            $this->bankId = $bankId;
        } elseif ($this->bankId) {
            $bank = Bank::find($this->bankId);
            if ($bank) {
                $this->bank_name = $bank->name_bank;  // Ensure this matches
                $this->rekening = $bank->rekening;
            }
        }
    }

    public function savebank()
    {
        $this->validate([
            'bank_name' => 'required|string|max:255',  // Make sure validation matches property name
            'rekening' => 'required|string|max:255',
        ]);

        if ($this->bankId) {
            $bank = Bank::find($this->bankId);
            $bank->update([
                'bank_name' => $this->bank_name,  // Correct name mapping here
                'rekening' => $this->rekening,
            ]);
            session()->flash('success', 'Bank updated successfully!');
        } else {
            Bank::create([
                'bank_name' => $this->bank_name,  // Correct name mapping here
                'rekening' => $this->rekening,
            ]);
            session()->flash('success', 'Bank created successfully!');
        }

        return redirect('payment_method');
    }

    public function render()
    {
        return view('livewire.bank.form-bank');
    }
}
