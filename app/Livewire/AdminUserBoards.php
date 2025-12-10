<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AdminUserBoards extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        $boards = $this->user->boards()->withCount('tasks')->get();

        return view('livewire.admin-user-boards', compact('boards'));
    }
}

