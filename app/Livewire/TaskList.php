<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Column;

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
}