<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public $totalUsers;
    public $totalBoards;
    public $totalTasks;
    public $primaryTasks;
    public $importantTasks;
    public $secondaryTasks;
    public $topUsers;
    public $columns;
    public $board;
    public $taskByDay;

    public function mount()
    {
        $this->totalUsers = User::count();
        $this->totalBoards = Board::count();
        $this->totalTasks = Task::count();

        $this->columns = Column::with('tasks.user')->get();
        $this->board = Board::first();

        $this->primaryTasks = Task::where('priority', 'primary')->count();
        $this->importantTasks = Task::where('priority', 'important')->count();
        $this->secondaryTasks = Task::where('priority', 'secondary')->count();

        $this->topUsers = User::withCount('boards')
            ->orderBy('boards_count', 'desc')
            ->take(5)
            ->get();

        $this->taskByDay = Task::selectRaw('DATE(created_at) as day, COUNT(*) as total')
    ->groupBy('day')
    ->orderBy('day', 'ASC')
    ->pluck('total', 'day');

    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
