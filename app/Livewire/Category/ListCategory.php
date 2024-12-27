<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ListCategory extends Component
{
    public $categories;

    public function mount() 
    {
        $this->categories = Category::all();
        // $this->refreshCategory();
    }

    public function deleteCategory($id)
    {
        // dd($id);
        try {
            // Cari kategori berdasarkan ID
            $category = Category::findOrFail($id);

            if ($category) {
                if ($category->status === 'Active') {
                    session()->flash('error', 'Category cannot be deleted because it is currently active.');
                    return;
                }
                $category->delete();
                $this->categories = Category::all();
                // $this->refreshCategory();
                // $this->dispatchBrowserEvent('categoryDeleted');
                session()->flash('success', 'Category deleted successfully!');
            } else {
                session()->flash('error', 'Category not defined!');
                
            }
        } catch (QueryException $e) {
            if ($e->getCode() == '23000') {
                session()->flash('error', 'Cannot delete category because it is being used in other data.');
            } else {
                session()->flash('error', 'An error occurred while deleting the category.');
            }
        }
    }

    public function refreshCategory()
    {
        $this->categories = Category::all();
    }

    public function render()
    {
        return view('livewire.category.list-category');
    }
}
