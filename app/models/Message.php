<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'product_id',
        'content',
        'is_read',
    ];

    // Message envoyé par
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Message reçu par
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // Message lié à un produit (optionnel)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}