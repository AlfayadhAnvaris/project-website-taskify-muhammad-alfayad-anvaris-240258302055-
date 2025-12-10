<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Board;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class BoardComments extends Component
{
    public $board;
    public $boardId;
    public $message;

    protected $rules = [
        'message' => 'required|string|max:1000'
    ];

    public function mount($boardId)
    {
        $this->board = Board::with('team', 'comments.user')->findOrFail($boardId);
        $this->boardId = $this->board->id;
    }

    public function postComment()
    {
        $this->validate();

        // hanya admin/owner team bisa komentar
        if ($this->board->team && !$this->board->team->isAdmin(Auth::id())) {
            session()->flash('error', 'Hanya admin team yang dapat memberi komentar.');
            return;
        }

        Comment::create([
            'board_id' => $this->boardId,
            'user_id'  => Auth::id(),
            'message'  => $this->message,
        ]);

        $this->message = '';

        session()->flash('success', 'Komentar berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.board-comments', [
            'comments' => $this->board->comments()->with('user')->latest()->get(),
        ]);
    }
}
