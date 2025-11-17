<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class EditTask extends Component
{
    public $showModal = false;
    public $taskId;
    public $title;
    public $description;

    protected $listeners = ['open-edit-task-modal' => 'openModal'];

   public function openModal($taskId)
{
    $task = Task::findOrFail($taskId);
    $this->taskId = $taskId;
    $this->title = $task->title;
    $this->description = $task->description;
    $this->showModal = true;
}

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function updateTask()
{
    $this->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task = Task::find($this->taskId);

    if ($task) {
        $task->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);
    }

     ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menambah Task',
        'description' => "User " . Auth::user()->name . " menambahkan task baru: {$task->title}"
    ]);

    $this->dispatch('taskUpdated');

    $this->closeModal();
}


    public function render()
    {
        return view('livewire.edit-task');
    }
}
