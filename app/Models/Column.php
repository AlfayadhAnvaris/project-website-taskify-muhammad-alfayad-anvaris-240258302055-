<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $fillable = ['name', 'board_id', 'position'];

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('position');
    }

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
}
