<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\Board;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class TeamBoardDetail extends Component
{
    public $team;
    public $board;

    public $message;

    public $editCommentId = null;
    public $editMessage = '';


    public function mount(Team $team, Board $board)
    {
        $this->team = $team;
        $this->board = $board;

        // Validasi: hanya anggota tim yang bisa mengakses
        if (!$team->users->contains(Auth::id())) {
            abort(403, 'Anda tidak memiliki akses ke board ini.');
        }
    }


    public function postComment()
{
    $this->validate([
        'message' => 'required|string|max:1000',
    ]);

    // Misal hanya admin/owner tim bisa komentar
    if ($this->board->team->owner_id !== auth()->id()) {
    session()->flash('error', 'Hanya admin team yang dapat memberi komentar.');
    return;
}


    \App\Models\Comment::create([
        'board_id' => $this->board->id,
        'user_id' => auth()->id(),
        'message' => $this->message,
    ]);

    $this->message = '';
    session()->flash('success', 'Komentar berhasil ditambahkan.');
}

  public function editComment(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && $this->board->team->owner_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak punya izin untuk mengedit komentar ini.');
            return;
        }

        $this->editCommentId = $comment->id;
        $this->editMessage = $comment->message;
    }

    // Update komentar
    public function updateComment()
    {
        $comment = Comment::find($this->editCommentId);
        if (!$comment) return;

        if ($comment->user_id !== Auth::id() && $this->board->team->owner_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak punya izin untuk mengedit komentar ini.');
            return;
        }

        $this->validate([
            'editMessage' => 'required|string|max:1000'
        ]);

        $comment->update([
            'message' => $this->editMessage
        ]);

        $this->editCommentId = null;
        $this->editMessage = '';
        session()->flash('success', 'Komentar berhasil diupdate.');
    }

    // Hapus komentar
    public function deleteComment(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && $this->board->team->owner_id !== Auth::id()) {
            session()->flash('error', 'Anda tidak punya izin untuk menghapus komentar ini.');
            return;
        }

        $comment->delete();
        session()->flash('success', 'Komentar berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.team-board-detail', [
            'comments' => $this->board->comments()->latest()->get(),
        ]);
    }
}
