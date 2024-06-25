<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{

    use WithPagination;

    #[Rule('required|min:3|max:50')]

    public $name;
    public $search;

    public $editingTodo = null;

    #[Rule('required|min:3|max:50')]
    public $editingName = null;

    public function create()
    {
        $validated = $this->validateOnly('name');
        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', "Created!");

        $this->resetPage();
    }

    public function delete($todoId)
    {
        Todo::destroy($todoId);
    }

    public function toggleComplete(Todo $todo)
    {
        $todo->is_completed = !$todo->is_completed;
        $todo->save();
    }

    public function edit(Todo $todo)
    {
        $this->editingTodo = $todo;
        $this->editingName = $todo->name;
    }

    public function update()
    {
        if ($this->editingTodo) {
            $this->validateOnly('editingName');
            $this->editingTodo->name = $this->editingName;
            $this->editingTodo->save();

            $this->cancelUpdate();
        }
    }

    public function cancelUpdate()
    {
        $this->editingTodo = null;
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5)
        ]);
    }
}
