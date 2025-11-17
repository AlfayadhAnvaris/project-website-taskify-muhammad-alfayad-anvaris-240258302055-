<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Task;
use Livewire\Component;

class AdminUsersIndex extends Component
{
    public $users;

    public function mount()
    {
        $this->loadUsers();
    }

    public function loadUsers()
    {
        $this->users = User::where('role', 'user')
            ->withCount('boards')
            ->get()
            ->map(function ($user) {

                $user->tasks_count = Task::whereHas('column.board', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->count();

                return $user;
            });
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('success', 'User berhasil dihapus.');

        $this->loadUsers(); // refresh list
    }

    public function render()
    {
        return view('livewire.admin-users-index');
    }
}
