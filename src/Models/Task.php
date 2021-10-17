<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['description', 'is_done', 'user_id'];

    public function scopeCurrentUser($query)
    {
        return $query->whereUserId($_SESSION['user']->id);
    }
}
