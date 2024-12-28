<?php

namespace App\Livewire\Units;

use App\Models\Unit;
use Livewire\Component;

class FormUnit extends Component
{
    public $unitId = null;
    public $name = '';
    public $short_name = '';
    public $status = true;

    protected $listeners = [
        'setUnitData'
    ];


    public function setUnitData($unitId)
    {
        $this->unitId = $unitId;
        if ($unitId) {
            $unit = Unit::find($unitId);
            if ($unit) {
                $this->name = $unit->name;
                $this->short_name = $unit->short_name;
                $this->status = $unit->status;
            }
        }
    }

    public function mount($unitId = null)
    {
        if ($unitId) {
            $this->unitId = $unitId;
        } elseif ($this->unitId) {
            $unit = Unit::find($this->unitId);
            if ($unit) {
                $this->name = $unit->name;
                $this->short_name = $unit->short_name;
                $this->status = $unit->status;
            }
        }
    }

    public function saveUnit()
    {
        $this->validate([
            'name' => 'required',
            'short_name' => 'required',
            'status' => 'required',
        ]);

        if ($this->unitId) {
            $unit = Unit::find($this->unitId);
            $unit->update([
                'name' => $this->name,
                'short_name' => $this->short_name,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Unit updated successfully!');
        } else {
            Unit::create([
                'name' => $this->name,
                'short_name' => $this->short_name,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Unit created successfully!');
        }

        return redirect('units');
    }
    public function render()
    {
        return view('livewire.units.form-unit');
    }
}
