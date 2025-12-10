<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;

class AdminBoardDetail extends Component
{
    public $board;

    public function mount(Board $board)
    {
        $this->board = $board->load('columns.tasks.user');
    }

    public function render()
    {
        return view('livewire.admin-board-detail');
    }
}

