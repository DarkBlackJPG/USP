<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'name', 'price', 'in_stock','description', 'image',
    ];
    public function users() {
        return $this->belongsToMany('App\User', 'users_products', 'user_id', 'product_id');
    }
}
