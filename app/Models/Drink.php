<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'prices',
        'volumes',
        'is_hit',
        'is_new',
        'is_discount',
    ];

    protected $casts = [
        'prices' => 'array',
        'volumes' => 'array',
        'is_hit' => 'boolean',
        'is_new' => 'boolean',
        'is_discount' => 'boolean',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_drinks')
            ->withPivot('quantity', 'volume', 'price')
            ->withTimestamps();
    }

    public function favoriteByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}