<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\Livewire;

class FormCategory extends Component
{
    public $categoryId = null;
    public $category = '';
    public $status = 'Active';

    protected $listeners = ['setCategoryData'];

    public function setCategoryData($categoryId)
    {
        $this->categoryId = $categoryId;

        if ($categoryId) {
            $category = Category::find($categoryId);
            if ($category) {
                $this->category = $category->category;
                $this->status = $category->status;
            }
        }
    }

    public function mount($categoryId = null)
    {
        if ($categoryId) {
            $this->categoryId = $categoryId;
        } elseif ($this->categoryId) {
            $category = Category::find($this->categoryId);
            if ($category) {
                $this->category = $category->category;
                $this->status = $category->status;
            }
        }
    }

    public function saveCategory()
    {
        $this->validate([
            'category' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($this->categoryId) {
            $category = Category::find($this->categoryId);
            $category->update([
                'category' => $this->category,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Category updated successfully!');
        } else {
            Category::create([
                'category' => $this->category,
                'status' => $this->status,
            ]);
            session()->flash('success', 'Category created successfully!');
        }

        return redirect('category');
    }

    public function render()
    {
        return view('livewire.category.form-category');
    }
}
