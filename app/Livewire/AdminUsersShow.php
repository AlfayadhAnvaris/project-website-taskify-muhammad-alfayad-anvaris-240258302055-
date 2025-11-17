<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Task;
use Livewire\Component;

class AdminUsersShow extends Component
{
    public $user;
    public $boards;
    public $tasks;

    public function mount(User $user)
    {
        $this->user = $user;

        $this->boards = $user->boards()->with('columns.tasks')->get();

        $this->tasks = Task::whereHas('column.board', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->get();
    }

    public function render()
    {
        return view('livewire.admin-users-show');
    }
}
