<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

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

     public function updateTaskPosition($taskId = null, $to = null, $position = null, $from = null)
    {
        if (!$taskId || !$to || $position === null) {
            Log::warning("updateTaskPosition dipanggil tanpa parameter lengkap.");
            return;
        }

        try {
            $task = Task::findOrFail($taskId);
            $oldColumnId = $task->column_id;
            $newColumnId = $to;

            Log::info("📦 Moving task {$task->id} from {$oldColumnId} to {$newColumnId} at position {$position}");

            // Update posisi & kolom
            $task->update([
                'column_id' => $newColumnId,
                'position' => $position,
            ]);

            // Reorder task di kolom lama & baru
            $this->reorderTasksInColumn($newColumnId);
            if ($oldColumnId !== $newColumnId) {
                $this->reorderTasksInColumn($oldColumnId);
            }

            // Optional: update priority sesuai kebutuhan (misal berdasarkan kolom atau logic lain)
            // $task->priority = ...;
            // $task->save();

            $this->dispatch('taskMoved', [
                'taskId' => $task->id,
                'from' => $oldColumnId,
                'to' => $newColumnId,
            ]);
        } catch (\Exception $e) {
            Log::error("❌ Error updating task position: " . $e->getMessage());
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Gagal memindahkan task.',
            ]);
        }
    }
}
