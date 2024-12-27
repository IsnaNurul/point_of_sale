<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\Livewire;

class FormCategory extends Component
{
    public $category;
    public $status;

    protected $rules = [
        'category' => 'required|unique:categories,category',
        'status' => 'required'
    ];

    public function saveCategory()
    {
        $this->validate();

        Category::create([
            'category' => $this->category,
            'status' => $this->status,
        ]);

        session()->flash('success', 'Category successfully created!');

        return redirect('category');
    }


    public function render()
    {
        return view('livewire.category.form-category');
    }
}
