<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TodoList extends Component
{
    public $tasks;
    public $newTask;

    public function mount()
    {
        $this->tasks = Task::all();
    }

    public function addTask()
    {
        $this->validate([
            'newTask' => 'required|min:3',
        ]);

        Task::create(['title' => $this->newTask]);
        $this->newTask = '';
        $this->tasks = Task::all();
    }

    public function markAsCompleted($taskId)
    {
        $task = Task::find($taskId);
        $task->is_completed = !$task->is_completed;
        $task->save();
        $this->tasks = Task::all();
    }

    public function deleteTask($taskId)
    {
        Task::find($taskId)->delete();
        $this->tasks = Task::all();
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}

