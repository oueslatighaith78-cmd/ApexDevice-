<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'content',
        'is_read',
        'created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

