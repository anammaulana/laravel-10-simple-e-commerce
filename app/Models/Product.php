<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'category', 'stock', 'image', 'size', 'color'];



    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

     public function ratings()
    {
        return $this->hasMany('App\Models\Rating');
    }

    public function purchasers()
    {
        return $this->belongsToMany(User::class, 'carts', 'product_id', 'user_id');
    }
    

}
