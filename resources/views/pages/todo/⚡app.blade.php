<?php

use Livewire\Component;
use App\Models\Todo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

new class extends Component {

    #[Validate('required|string|min:3|max:255')]
    public string $newTitle = '';

    #[Computed()]
    public function todos()
    {
        $todos = Todo::query()->latest()->get();
        return $todos;
    }

    public function addTodo()
    {
        $this->validate();
        
        Todo::create([
            'title' => $this->newTitle,
        ]);
        $this->newTitle = '';
    }
    
    
};
?>

<div
    class="max-w-3xl w-full max-auto py-12 px-6 bg-sky-500 text-zinc-800 dark:text-zinc-100 border border-zinc-200 rounded-md">
    <h1 class="text-2xl">Todo List CRUD Livewire</h1>

    {{-- {{ dd($this->todos()) }} --}}


    <div class="todo-list">
        <form wire:submit.prevent="addTodo" class="mt-6 flex gap-3 flex-col">
            <div class="flex items-center gap-3">
                <input type="text" wire:model.live.blur="newTitle" placeholder="Enter todo title"
                    class="flex-1 px-4 py-2 border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" />

                <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-md hover:bg-sky-700">
                    Add Todo
                </button>
            </div>
            <div>
                @error('newTitle')
                    <span class="text-red-500 dark:text-red-300">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>

    <ul class="mt-6 space-y-3">

        @foreach($this->todos as $todo)
           <livewire:todo.item wire:key="{{ $todo->id }}" :todo="$todo"  />
        @endforeach

    </ul>

</div>