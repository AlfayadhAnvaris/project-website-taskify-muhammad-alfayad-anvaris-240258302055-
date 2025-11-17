<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;
use Livewire\Component;

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
    public $taskByMonth;

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

        $this->taskByMonth = Task::selectRaw("COUNT(*) as total, DATE_FORMAT(created_at, '%M') as month")
            ->groupBy('month')
            ->pluck('total', 'month');
    }

    public function render()
    {
        return view('livewire.admin-dashboard');
    }
}
