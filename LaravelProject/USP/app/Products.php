<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Products extends Model
{
    protected $fillable = [
        'name', 'price', 'in_stock','description', 'image',
    ];
    public $timestamps = false;

    public function users() {
        return $this->belongsToMany('App\User', 'users_products', 'product_id', 'user_id')
            ->withPivot(['id', 'user_id'], 'amount');
    }
    public function cart() {
        return $this->belongsToMany('App\User', 'users_products_cart', 'product_id', 'user_id')
            ->withPivot(['id', 'user_id'], 'amount');
    }
}
