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
    }

    public function deleteCategory($id)
    {
        try {
            // Cari kategori berdasarkan ID
            $category = Category::findOrFail($id);

            if ($category) {
                if ($category->status === 'Active') {
                    session()->flash('error', 'Category cannot be deleted because it is currently active.');
                    return redirect('category');
                }
                $category->delete();
                $this->refreshCategory();
                session()->flash('success', 'Category deleted successfully!');
                return redirect('category');
            } else {
                session()->flash('error', 'Category not defined!');
                return redirect('category');
            }
        } catch (QueryException $e) {
            $this->handleQueryException($e);
        }
    }

    private function handleQueryException(QueryException $e)
    {
        if ($e->getCode() === '23000') {
            session()->flash('error', 'Cannot delete category because it is being used in other data.');
        } else {
            session()->flash('error', 'An error occurred while deleting the category.');
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
