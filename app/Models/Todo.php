<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    public const ON_HOLD = 'on_hold';
    public const IN_PROGRESS = 'in_progress';
    public const COMPLETED = 'completed';

    public static $todo_statuses = [self::ON_HOLD, self::IN_PROGRESS, self::COMPLETED];

    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
