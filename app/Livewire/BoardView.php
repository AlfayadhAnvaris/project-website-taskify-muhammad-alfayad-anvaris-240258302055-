<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class BoardView extends Component
{
    public $board;
    public $columns;

    protected $listeners = [
        'refreshBoard' => 'loadColumns',
        'taskMoved' => 'updateTaskPosition',
        'columnAdded' => 'refreshColumns',
        'deleteTask' => 'deleteTask',
        'deleteColumn' => 'deleteColumn',
        'markAsDone' => 'markAsDone',
        'taskUpdated' => '$refresh',
    ];


    public function mount($boardId = null)
    {

        $user = auth()->user();
        $boards = Board::where(function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhereHas('team.users', fn($q2) => $q2->where('users.id', $user->id))
                ->orWhereHas('team', fn($q3) => $q3->where('owner_id', $user->id));
        })->get();

        $this->board = Board::with('columns.tasks')->find($boardId);

        if ($boardId) {
            $this->board = Board::with('columns.tasks')->find($boardId);
        }

        if (!$this->board) {
            $this->board = Board::with('columns.tasks')->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhereHas('team.users', fn($q2) => $q2->where('users.id', $user->id))
                    ->orWhereHas('team', fn($q3) => $q3->where('owner_id', $user->id));
            })->first();
        }

        if (!$this->board) {
            $this->board = Board::create([
                'name' => 'Default Project Board',
                'user_id' => $user->id,
            ]);
        }


        $this->board->load('columns.tasks');
        $this->loadColumns();
    }



    public function loadColumns()
    {
        $this->columns = $this->board->columns()
            ->with(['tasks' => fn($q) => $q->orderBy('position')])
            ->orderBy('position')
            ->get();
    }

    /** ✅ Tambahkan ini */
    public function refreshColumns()
    {
        // Ambil ulang data board supaya relasi columns ter-update
        $this->board->refresh();
        $this->loadColumns();
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

    public function markAsDone($taskId)
    {
        Task::where('id', $taskId)->update(['priority' => 'secondary']);
        $this->loadColumns();
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'Task ditandai selesai!',
        ]);
    }


    private function reorderTasksInColumn($columnId)
    {
        $tasks = Task::where('column_id', $columnId)
            ->orderBy('position')
            ->get();

        foreach ($tasks as $index => $task) {
            if ($task->position !== $index) {
                $task->updateQuietly(['position' => $index]);
            }
        }
    }

    public function deleteTask($taskId)
    {
        $task = \App\Models\Task::find($taskId);
        if ($task) {
            $task->delete();
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Task berhasil dihapus!',
            ]);
            $this->loadColumns();
        }
    }

    public function deleteColumn($columnId)
    {
        $column = \App\Models\Column::find($columnId);
        if ($column) {
            $column->delete();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Kolom berhasil dihapus!',
            ]);

            $this->loadColumns(); // refresh
        }
    }

    public function updateTaskPriority($taskId, $priority)
    {
        $task = Task::find($taskId);
        if ($task) {
            $task->priority = $priority;
            $task->save();

            $this->loadColumns(); // refresh board

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Priority task diperbarui!',
            ]);
        }
    }
    public $editingTaskId = null;
    public $editingTaskTitle = '';


    public function startEditingTask($taskId)
    {
        $task = Task::find($taskId);
        if ($task) {
            $this->editingTaskId = $taskId;
            $this->editingTaskTitle = $task->title;
        }
    }

    public function saveTaskTitle($taskId)
    {
        $task = Task::find($taskId);
        if ($task && $this->editingTaskTitle !== '') {
            $task->update(['title' => $this->editingTaskTitle]);
            $this->dispatch('toast', message: 'Task updated successfully!', type: 'success');
        }

        $this->editingTaskId = null;
        $this->editingTaskTitle = '';
    }



    public function render()
    {
        return view('livewire.board-view', [
            'board' => $this->board, // singular, sesuai isi-nya
            'columns' => $this->columns,
        ]);
    }
}
