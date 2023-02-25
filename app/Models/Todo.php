<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'todo_id',
        'title',
        'description',
        'end_date',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function parent() {
        return $this->belongsTo(Todo::class, 'todo_id');
    }

    public function nested() {
        return $this->hasMany(Todo::class);
    }
}
