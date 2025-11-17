<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;

class Dashboard extends Component
{
    protected $listeners = [
        'columnAdded' => '$refresh',
        'taskAdded' => '$refresh',
        'taskMoved' => '$refresh',
        'taskUpdated' => '$refresh',
        'taskDeleted' => '$refresh',
    ];

    public $board;
    public $totalBoards;
    public $totalColumns;
    public $totalTasks;
    public $completedTasks;
   

  public $primaryTasks;
public $importantTasks;
public $secondaryTasks;

public function mount($boardId = null)
{
    // Ambil board
    $this->board = Board::with('columns.tasks')->find($boardId)
        ?? Board::with('columns.tasks')->first();

    if (!$this->board) {
        $this->board = Board::create(['name' => 'Default Project Board']);
    }

    $this->totalBoards = Board::count();
    $this->totalColumns = Column::count();
    $this->totalTasks = Task::count();

    $this->primaryTasks   = Task::where('priority', 'primary')->count();
    $this->importantTasks = Task::where('priority', 'important')->count();
    $this->secondaryTasks = Task::where('priority', 'secondary')->count();
}



    public function render()
    {
        // Persiapkan data untuk tampilan kanban
        $columns = $this->board->columns()->with('tasks')->orderBy('position')->get();

        return view('livewire.dashboard', [
            'board' => $this->board,
            'columns' => $columns,
            'totalBoards' => $this->totalBoards,
            'totalColumns' => $this->totalColumns,
            'totalTasks' => $this->totalTasks,

            
        ]);
    }
}
