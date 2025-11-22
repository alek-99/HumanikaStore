<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'deskripsi',
        'harga',
        'image',
        'kategori',
        'stok',
    ];

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
