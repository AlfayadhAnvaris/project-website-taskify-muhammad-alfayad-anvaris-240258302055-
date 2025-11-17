<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'column_id', 'position', 'priority'];

    public function column()
    {
        return $this->belongsTo(Column::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}

