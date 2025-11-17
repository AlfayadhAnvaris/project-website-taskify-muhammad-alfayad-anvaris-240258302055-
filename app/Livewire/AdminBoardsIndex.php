<?php

namespace App\Livewire;

use App\Models\Board;
use Livewire\Component;

class AdminBoardsIndex extends Component
{
    public $boards;

    public function mount()
    {
        $this->boards = Board::with('columns.tasks')->get();
    }

    public function render()
    {
        return view('livewire.admin.boards-index');
    }
}
