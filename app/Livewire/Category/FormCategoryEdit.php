<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;

class FormCategoryEdit extends Component 
{
    public $category_id, $category_name, $status;

    // Initialize component with category data for editing
    public function mount($categoryId)
    {
        $category = Category::find($categoryId);

        $this->category_id = $category->id;
        $this->category_name = $category->category;
        $this->status = $category->status;
    }

    // Update category logic
    public function updateCategory()
    {
        $category = Category::find($this->category_id);
        $category->category = $this->category_name;
        $category->status = $this->status;
        $category->save();

        session()->flash('success', 'Category updated successfully!');
        return redirect('category');
    }

    public function render()
    {
        return view('livewire.category.form-category-edit');
    }
}

