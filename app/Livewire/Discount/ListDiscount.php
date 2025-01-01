<?php

namespace App\Livewire\Discount;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ListDiscount extends Component
{
    public $discounts;

    public function mount()
    {
        $this->discounts = Discount::all();
        $this->checkAndUpdateDiscountStatus();
    }
    public function checkAndUpdateDiscountStatus()
    {
        $now = now()->timezone('Asia/Jakarta');
        foreach ($this->discounts as $discount) {
            $startAt = Carbon::parse($discount->start_at);
            $endAt = Carbon::parse($discount->end_at);
            if ($now->gte($startAt) && $now->lte($endAt)) {
                $discount->status = 1;
            } else {
                $discount->status = 0;
            }

            // cek apakah jam sekarang sudah melebihi jam end_at
            if ($now->format('H:i:s') > $endAt->format('H:i:s')) {
                $discount->status = 0;
            }
            // dd($now->format('H:i:s'), $endAt->format('H:i:s'));

            $discount->save();
        }
        $this->refreshDiscount();
    }


    public function deleteDiscount($id)
    {
        try {
            $discount = Discount::findOrFail($id);

            if ($discount) {
                if ($discount->status === 1) {
                    session()->flash('error', 'discount cannot be deleted because it is currently active.');
                    return;
                }
                $discount->delete();
                $this->refreshDiscount();
                session()->flash('success', 'discount deleted successfully!');
            } else {
                session()->flash('error', 'discount not defined!');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }



    private function refreshDiscount()
    {
        $this->discounts = Discount::all();
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete discount because it is being used in other data.');
        } else {
            session()->flash('error', 'An error occurred while deleting the discount.');
        }
    }
    public function render()
    {
        return view('livewire.discount.list-discount');
    }
}
