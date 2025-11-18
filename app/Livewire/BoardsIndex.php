<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Livewire\Component;
use App\Models\Board;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BoardsIndex extends Component
{
    public Collection $boards;
    public $newBoardName = '';

    public function mount()
    {
        $this->boards = Board::latest()->get();
    }

    public function createBoard()
    {
        $this->validate([
            'newBoardName' => 'required|min:3',
        ]);

        $board = Board::create([
            'name' => $this->newBoardName,
            'user_id' => Auth::id(),
        ]);

        $this->newBoardName = '';
        $this->boards->prepend($board);

        $this->dispatcha('toast', [
            'type' => 'success',
            'message' => 'Board baru berhasil ditambahkan!',
        ]);

         ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menambah Board',
        'description' => "User " . Auth::user()->name . " menambahkan board baru: {$board->name}"
    ]);
    }

    public function deleteBoard($boardId)
    {
        $board = Board::find($boardId);

        if ($board) {
            $board->delete();

            $this->boards = Board::latest()->get();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'Board berhasil dihapus!',
            ]);
        }

         ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Menghapus Board',
        'description' => "User " . Auth::user()->name . " menghapus board: {$board->name}"
    ]);
    }

    public function show(Board $board)
{
    $this->authorize('view', $board); // jika pakai policy
    return view('user.boards.show', compact('board'));
}


    public function render()
    {
        return view('livewire.boards-index', [
            'boards' => $this->boards,
        ]);
    }
}
