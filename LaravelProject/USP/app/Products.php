<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name', 'price', 'in_stock','description', 'image',
    ];
    public function users() {
        return $this->belongsToMany('App\User', 'users_products', 'product_id', 'user_id')->withPivot(['id', 'user_id']);
    }
    public function cart() {
        return $this->belongsToMany('App\User', 'users_products_cart', 'product_id', 'user_id')->withPivot(['id', 'user_id']);
    }
}
