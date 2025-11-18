<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $fillable = ['name', 'user_id'];

   public function user()
{
    return $this->belongsTo(User::class);
}

public function columns()
{
    return $this->hasMany(Column::class);
}

public function team()
{
    return $this->belongsTo(Team::class);
}

public function tasks()
{
    return $this->hasManyThrough(
        Task::class,
        Column::class,
        'board_id', // Foreign key di columns
        'column_id', // Foreign key di tasks
        'id', // local key board
        'id' // local key column
    );
}



    
}

