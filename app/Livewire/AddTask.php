<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;
use App\Models\Task;
use App\Models\Column;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AddTask extends Component
{
    public $boardId;
  public $showModal = false;
    public $selectedColumnId;
    public $selectedColumnName = '';
    
    public $newTaskTitle = '';
    public $newTaskDescription = '';

    protected $rules = [
        'newTaskTitle' => 'required|string|max:255',
        'newTaskDescription' => 'nullable|string|max:1000',
    ];

    protected $messages = [
        'newTaskTitle.required' => 'Judul task harus diisi',
        'newTaskTitle.max' => 'Judul task maksimal 255 karakter',
        'newTaskDescription.max' => 'Deskripsi maksimal 1000 karakter',
    ];

    protected $listeners = ['open-add-task-modal' => 'openModal'];

 public function openModal($columnId, $columnName)
{
    $this->resetForm();
    $this->selectedColumnId = $columnId;
    $this->selectedColumnName = $columnName;
    $this->showModal = true;
}

public function closeModal()
{
    $this->showModal = false;
    $this->resetForm();
}

private function resetForm()
{
    $this->newTaskTitle = '';
    $this->newTaskDescription = '';
    $this->resetErrorBag();
}

public function addTask()
{
    $this->validate();
    $maxPosition = Task::where('column_id', $this->selectedColumnId)->max('position') ?? -1;

    $task = Task::create([
        'title' => $this->newTaskTitle,
        'description' => $this->newTaskDescription,
        'column_id' => $this->selectedColumnId,
        'position' => $maxPosition + 1,
        'status' => 'pending',
    ]);

     ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menambah Task',
        'description' => "User " . Auth::user()->name . " menambahkan task baru: {$task->title}"
    ]);

    $this->closeModal();
    $this->dispatch('refreshBoard')->to('board-view');
    $this->dispatch('task-added', message: 'Task berhasil ditambahkan!');
}

public function deleteTask($taskId)
{
    $task = Task::find($taskId);
    if ($task) {
        $task->delete();

        $this->dispatchBrowserEvent('toast', [
            'type' => 'success',
            'message' => 'Task berhasil dihapus!',
        ]);

        $this->dispatch('refreshBoard')->to('board-view');
    }

     ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menghapus Task',
        'description' => "User " . Auth::user()->name . " menghapus task: {$task->title}"
    ]);
}


    public function render()
    {
        return view('livewire.add-task');
    }
}