<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeamManagement extends Component
{
    public $teams; // Collection of teams
    public $teamName = '';
    public $inviteEmail = '';
    public $selectedTeamId = null; // gunakan ID saja

    protected $rules = [
        'teamName' => 'required|string|max:255',
        'inviteEmail' => 'required|email|exists:users,email',
    ];

    public function mount()
    {
        $this->loadTeams();
    }

    // Ambil tim milik user atau tim yang dia anggota
   public function loadTeams()
{
    $this->teams = Team::with('owner')
        ->where('owner_id', Auth::id())
        ->orWhereHas('users', fn($q) => $q->where('users.id', Auth::id()))
        ->get();
}


    // Membuat tim baru
    public function createTeam()
    {
        $this->validateOnly('teamName');

        $team = Team::create([
            'name' => $this->teamName,
            'owner_id' => Auth::id(),
        ]);

        // Auto attach owner ke tim
        $team->users()->attach(Auth::id());

        $this->teamName = '';
        $this->loadTeams();
        session()->flash('success', 'Team berhasil dibuat!');
    }

    // Pilih tim berdasarkan ID
    public function selectTeam($teamId)
    {
        $this->selectedTeamId = $teamId;
    }

    // Mendapatkan model tim dari ID
    private function selectedTeam()
    {
        return $this->selectedTeamId ? Team::find($this->selectedTeamId) : null;
    }

    // Invite user ke tim
    public function inviteUser()
    {
        $this->validateOnly('inviteEmail');

        $team = $this->selectedTeam();
        if (!$team) return;

        $user = User::where('email', $this->inviteEmail)->first();

        if ($team->users()->where('user_id', $user->id)->exists()) {
            session()->flash('error', 'User sudah anggota tim.');
            return;
        }

        $team->users()->attach($user->id);
        $this->inviteEmail = '';
        $this->loadTeams();
        session()->flash('success', 'User berhasil diundang!');
    }

    // Hapus user dari tim
    public function removeUser($userId)
    {
        $team = $this->selectedTeam();
        if (!$team) return;

        $team->users()->detach($userId);
        $this->loadTeams();
        session()->flash('success', 'User dihapus dari tim.');
    }

    public function render()
    {
        return view('livewire.team-management', [
            'selectedTeam' => $this->selectedTeam(), // passing model ke view jika perlu
        ]);
    }
}
