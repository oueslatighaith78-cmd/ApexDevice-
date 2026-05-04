<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title',
        'description', 'price', 'image',
    ];

    public function user()        { return $this->belongsTo(User::class); }
    public function category()    { return $this->belongsTo(Category::class); }
    public function reviews()     { return $this->hasMany(Review::class); }
    public function messages()    { return $this->hasMany(Message::class); }
    public function cartItems()   { return $this->hasMany(CartItem::class); }
    public function orderItems()  { return $this->hasMany(OrderItem::class); }
    public function wishlists()   { return $this->hasMany(Wishlist::class); }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}
