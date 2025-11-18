<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BoardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
  public function view(User $user, Board $board)
{
    // Board tanpa tim bisa diakses oleh owner
    if (!$board->team_id) {
        return $board->user_id === $user->id;
    }

    // Board yang terkait tim, cek apakah user anggota tim
    return $board->team->users->contains($user->id) || $board->team->owner_id === $user->id;
}

public function update(User $user, Board $board)
{
    // Sama seperti view
    return $this->view($user, $board);
}


}
