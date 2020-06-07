<?php

namespace App\Http\Controllers;

use App\Products;
use App\User;
use Illuminate\Http\Request;
use App\Mail\ConfirmPurchase;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function getMyProducts() {
        $myProducts = auth()->user()->products;

        return view('my_products', ['products' => $myProducts]);
    }
    public function getCart() {
        $cart = auth()->user()->cart()->get();
        return view('cart_view', ['products' => $cart]);
    }
    public function putInCart($product) {
        $product = Products::find($product);
        if($product->in_stock == 0){
            return redirect()->route('home');
        }
        $product->in_stock--;
        $product->timestamps = false;
        $product->save();
        $product->cart()->attach(auth()->user()->id);
        return redirect()->back();
    }
    public function cancelCart($user) {
        $user = User::find($user);
        $products = $user->cart()->get();
        foreach ($products as $product) {
            $entity = Products::find($product->id);
            $entity->in_stock++;
            $entity->timestamps = false;
            $entity->save();
            $entity->cart()->detach($user->id);
        }
        return redirect()->route('home')->with('cancel_cart', 'null');
    }

    /**
     * Buys one item
     * @deprecated
     * @param $product
     * @return \Illuminate\Http\RedirectResponse
     */
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

    public function buyAllItems($user) {
        $user = User::find($user);
        $products = $user->cart()->get();
        $productList = [];
        foreach ($products as $product) {
            array_push($productList, $product);
            $entity = Products::find($product->id);
            $entity->users()->attach($user->id);
            $entity->cart()->detach($user->id);
        }
        $email = auth()->user()->email;
        Mail::to($email)->send(new ConfirmPurchase($productList, auth()->user()));
        return redirect()->route('home')->with('success_purchase', 'null');
    }
}
