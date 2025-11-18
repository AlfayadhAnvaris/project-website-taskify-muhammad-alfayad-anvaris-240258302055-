<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamInvitation extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'email', 'token', 'accepted_at'];

    // Tim terkait
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Cek apakah sudah diterima
    public function isAccepted()
    {
        return $this->accepted_at !== null;
    }
}
