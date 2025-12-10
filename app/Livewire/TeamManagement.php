<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\User;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class TeamManagement extends Component
{
    public $teams;              // Semua tim user
    public $teamName = '';       // Input nama tim
    public $inviteEmail = '';    // Input email invite
    public $selectedTeamId = null; 
    public $boardName = '';      // Input nama board
    public $teamBoards;          // Board untuk tim yang dipilih

    protected $rules = [
        'teamName' => 'required|string|max:255',
        'inviteEmail' => 'required|email|exists:users,email',
    ];

    public function mount()
    {
        $this->loadTeams();
        $this->teamBoards = collect(); // Inisialisasi kosong
    }

    /**
     * Ambil semua tim milik user atau dia anggota
     */
    public function loadTeams()
    {
        $this->teams = Team::with('owner', 'users', 'boards')
            ->where('owner_id', Auth::id())
            ->orWhereHas('users', fn($q) => $q->where('users.id', Auth::id()))
            ->get();
    }

    /**
     * Buat tim baru
     */
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

    /**
     * Pilih tim
     */
    public function selectTeam($teamId)
    {
        $this->selectedTeamId = $teamId;
        $team = $this->selectedTeam();
        if ($team) {
            $this->teamBoards = $team->boards()->latest()->get(); // ambil board tim
        } else {
            $this->teamBoards = collect();
        }
    }

    /**
     * Ambil model tim yang dipilih
     */
    private function selectedTeam()
    {
        return $this->selectedTeamId ? Team::with('users', 'boards')->find($this->selectedTeamId) : null;
    }

    /**
     * Invite user ke tim
     */
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

    /**
     * Hapus user dari tim
     */
    public function removeUser($userId)
    {
        $team = $this->selectedTeam();
        if (!$team) return;

        $team->users()->detach($userId);
        $this->loadTeams();
        session()->flash('success', 'User dihapus dari tim.');
    }

    /**
     * Buat board untuk tim yang dipilih
     */
    public function createBoard()
    {
        $this->validate([
            'boardName' => 'required|string|max:255'
        ]);

        $team = $this->selectedTeam();
        if (!$team) {
            session()->flash('error', 'Pilih tim terlebih dahulu.');
            return;
        }

        $board = $team->boards()->create([
            'name' => $this->boardName,
            'user_id' => Auth::id()
        ]);

        // Tambahkan board baru ke collection
        $this->teamBoards->push($board);

        $this->boardName = '';
        session()->flash('success', 'Board berhasil dibuat untuk tim.');
    }

    public function render()
    {
        return view('livewire.team-management', [
            'selectedTeam' => $this->selectedTeam(),
            'teamBoards' => $this->teamBoards
        ]);
    }
}
