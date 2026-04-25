<?php

use Livewire\Component;
use App\Models\Todo;



new class extends Component
{
    public Todo $todo;
    public string $newTitle = '';
    
    public bool $isEditing = false;

    public function mount()
    {
        $this->newTitle = $this->todo->title;
    }

    public function todoCompleted()
    {


        $this->todo->update([
            'completed' => $this->todo->completed ? false : true,
        ]);
    }

    public function deleteTodo()
    {
        $this->todo->delete();
    }

    public function editTodo()
    {
        $this->isEditing = true;
    }

    public function updateTodo()
    {
        $this->validate([
            'newTitle' => 'required|string|min:3|max:255',
        ]);

        $this->todo->update([
            'title' => $this->newTitle,
        ]);
        $this->isEditing = false;
    }

    public function cancelEdit()
    {
        $this->newTitle = $this->todo->title;
        $this->isEditing = false;
    }

};
?>
 <li class="flex items-center justify-between p-4 bg-white dark:bg-zinc-200 rounded-md shadow-sm">
                <div class="flex items-center gap-3">
                    <input wire:click="todoCompleted()" wire:confirm="Are you sure?" type="checkbox" class="w-5 h-5 text-sky-600 rounded focus:ring-sky-500 cursor-pointer" {{ $todo->completed ? 'checked' : '' }}>

                    @if (!$isEditing)    
                    <span @class([
                        'text-zinc-800 dark:text-zinc-100',
                        'line-through' => $todo->completed
                    ])>{{ $todo->title }}</span>
                                    
            @else        
            <form wire:submit.prevent="updateTodo" class="flex items-center gap-2">
                <input type="text" wire:model.live.blur="newTitle" placeholder="Enter todo title"
                    class="flex-1 px-4 py-2 border border-zinc-300 rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500 text-zinc-800" />

                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                   Update
                </button>

                <button wire:click="cancelEdit" type="button" class="px-4 py-2 bg-zinc-400 text-white rounded-md hover:bg-zinc-500">
                   Cancel
                </button>
            </form>
            @endif

    
                </div>
                <div class="flex items-center gap-2">
                    <button wire:click="editTodo()" title="Edit" class="cursor-pointer text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.536L16.732 3.732z" />
                        </svg>
                    </button>
                    <button wire:click="deleteTodo()" wire:confirm="Are you sure?" title="Delete" class="cursor-pointer text-red-500 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </li>