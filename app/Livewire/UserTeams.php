<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserTeams extends Component
{
    use WithPagination;

    public $search = '';
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function createTeam()
    {
        $this->validate();

        $team = Team::create([
            'name' => $this->name,
            'owner_id' => Auth::id(),
        ]);

        // Tambahkan creator ke tim
        $team->users()->attach(Auth::id(), ['is_admin' => true,]);

        $this->name = '';
        session()->flash('success', 'Team berhasil dibuat!');
    }

 public function render()
{
    $teams = Auth::user()->teams() // note: pakai ()
        ->when($this->search, fn($query) => $query->where('name', 'like', "%{$this->search}%"))
        ->paginate(10);

    return view('livewire.user-teams', ['teams' => $teams]);
}

}

