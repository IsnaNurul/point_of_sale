<?php

namespace App\Livewire\Units;

use App\Models\Unit;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ListUnits extends Component
{
    public $units;
    public function mount()
    {
        $this->units = Unit::all();
    }
    public function deleteUnit($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            if ($unit) {
                if ($unit->status == 'Active') {
                    session()->flash('error', 'Unit cannot be deleted because it is currently active.');
                    return;
                }
                $unit->delete();
                $this->refreshUnit();
                session()->flash('success', 'Unit deleted successfully!');
            } else {
                session()->flash('error', 'Unit not defined!');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete unit because it is being used in other data.');
        } else {
            session()->flash('error', 'An error occurred while deleting the unit.');
        }
    }

    public function refreshUnit()
    {
        $this->units = Unit::all();
    }
    public function render()
    {
        return view('livewire.units.list-units');
    }
}
