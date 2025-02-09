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
        // $this->checkAndUpdateDiscountStatus();
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

    public function toggleStatus($id)
    {
        try {

            $discount = Discount::findOrFail($id);

            $now = now()->timezone('Asia/Jakarta');
            $endAt = Carbon::parse($discount->end_at);

            if ($endAt->lt($now)) {
                session()->flash('error', 'This voucher has expired and cannot be activated.');
                return;
            }
            // Ubah status
            $discount->status = $discount->status == 1 ? 0 : 1;
            $discount->save();

            // Refresh data diskon
            $this->refreshDiscount();

            session()->flash('success', 'Discount status updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update discount status.');
        }
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
