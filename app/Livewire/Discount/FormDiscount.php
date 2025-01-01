<?php

namespace App\Livewire\Discount;

use App\Models\Discount;
use Carbon\Carbon;
use Livewire\Component;

class FormDiscount extends Component
{
    public $discountId = null;
    public $name = '';
    public $code = '';
    public $type = '';
    public $description = '';
    public $value = '';
    public $start_at = '';
    public $end_at = '';
    public $limit = '';
    public $status = 1;

    protected $listeners = ['setDiscountData'];
    public function setDiscountData($discountId)
    {
        $this->discountId = $discountId;

        if ($discountId) {
            $discount = Discount::find($discountId);
            if ($discount) {
                $this->name = $discount->name;
                $this->code = $discount->code;
                $this->type = $discount->type;
                $this->description = $discount->description;
                $this->value = $discount->value;
                $this->start_at = $discount->start_at;
                $this->end_at = $discount->end_at;
                $this->limit = $discount->limit;
                $this->status = $discount->status;
            }
        }
    }


    public function mount($discountId = null)
    {
        if ($discountId) {
            $this->discountId = $discountId;
        } elseif ($this->discountId) {
            $discount = Discount::find($this->discountId);
            if ($discount) {
                $this->name = $discount->name;
                $this->code = $discount->code;
                $this->type = $discount->type;
                $this->description = $discount->description;
                $this->value = $discount->value;
                $this->start_at = $discount->start_at;
                $this->end_at = $discount->end_at;
                $this->limit = $discount->limit;
                $this->status = $discount->status;
            }
        }
    }
    public function saveDiscount()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required',
            'type' => 'required',
            'description' => 'required|string',
            'value' => 'required|integer|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'limit' => 'required|integer|min:0',
            'status' => 'required',
        ]);
        if ($this->discountId) {
            $discount = Discount::find($this->discountId);
            $discount->update([
                'name' => $this->name,
                'code' => $this->code,
                'type' => $this->type,
                'description' => $this->description,
                'value' => $this->value,
                'start_at' => Carbon::parse($this->start_at),
                'end_at' => Carbon::parse($this->end_at),
                'limit' => $this->limit,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Discount updated successfully!');
        } else {
            Discount::create([
                'name' => $this->name,
                'code' => $this->code,
                'type' => $this->type,
                'description' => $this->description,
                'value' => $this->value,
                'start_at' => Carbon::parse($this->start_at),
                'end_at' => Carbon::parse($this->end_at),
                'limit' => $this->limit,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Discount created successfully!');
        }

        return redirect('discount');
    }
    public function render()
    {
        return view('livewire.discount.form-discount');
    }
}
