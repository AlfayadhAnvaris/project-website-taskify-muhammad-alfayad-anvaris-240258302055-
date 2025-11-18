<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;
use App\Models\Column;
use App\Models\Task;

class TaskList extends Component
{
    public $column; // Terima column object dari parent

    public function mount(Column $column)
    {
        $this->column = $column;
    }

    public function render()
    {
        return view('livewire.task-list');
    }

    public function show(Board $board, Task $task)
{
    return view('user.tasks.show', compact('board', 'task'));
}

}