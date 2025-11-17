<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;
use App\Models\Column;
use Illuminate\Support\Facades\Auth;

class AddColumn extends Component
{
    public $boardId;
    public $name;



    protected $rules = [
        'name' => 'required|min:3'
    ];

    // ✅ Tambahkan mount() agar boardId diterima dari view
    public function mount($boardId)
    {
        $this->boardId = $boardId;
    }

    public function addColumn()
{
    $this->validate();

    $position = Column::where('board_id', $this->boardId)->max('position') + 1;

    Column::create([
        'board_id' => $this->boardId,
        'name' => $this->name,
        'position' => $position,
    ]);

    $this->reset('name');

    $this->dispatch('columnAdded')->to('board-view');

    $this->dispatch('toast', [
        'type' => 'success',
        'message' => 'Kolom baru berhasil ditambahkan!',
    ]);

     ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menambah Task',
        'description' => "User " . Auth::user()->name . " menambahkan kolom baru: {$this->name}"
    ]);
}

public function deleteColumn($columnId)
{
    $column = Column::find($columnId);
    if ($column) {
        $column->delete();

        $this->dispatchBrowserEvent('toast', [
            'type' => 'success',
            'message' => 'Kolom berhasil dihapus!',
        ]);

        $this->loadColumns(); 
    }
     ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menghapus Kolom',
        'description' => "User " . Auth::user()->name . " menghapus kolom: {$column->name}"
    ]);
}



    public function render()
    {
        return view('livewire.add-column');
    }
}
