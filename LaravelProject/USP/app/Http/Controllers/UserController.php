<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use App\Mail\ConfirmPurchase;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function getMyProducts() {
        $myProducts = auth()->user()->products;

        return view('my_products', ['products' => $myProducts]);
    }

    public function buyItem($product) {
        $email = auth()->user()->email;
        $product = Products::find($product);
        if($product->in_stock == 0){
            return redirect()->route('home');
        }
        $product->in_stock--;
        $product->timestamps = false;
        $product->save();
        $product->users()->attach(auth()->user()->id);

        Mail::to($email)->send(new ConfirmPurchase($product, auth()->user()));

        return redirect()->route('home')->with('success_purchase','dsadas');
    }
}
