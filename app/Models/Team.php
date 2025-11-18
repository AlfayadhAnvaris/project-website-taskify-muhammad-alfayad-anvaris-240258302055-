<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Anggota tim
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('is_admin')
                    ->withTimestamps();
    }

    /**
     * Boards yang dimiliki tim
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    /**
     * Undangan yang dikirim untuk tim ini
     */
    public function invitations()
    {
        return $this->hasMany(TeamInvitation::class);
    }

    /**
     * Admin tim
     */
    public function admins()
    {
        return $this->users()->wherePivot('is_admin', true);
    }

    public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}

}
