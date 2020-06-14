<?php

namespace App\Http\Controllers;

use App\Products;
use App\User;
use Illuminate\Http\Request;
use App\Mail\ConfirmPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

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

    public function putInCart(Request $request) {
        $product = Products::find($request->id);
        $val = $request->buy;
        if($product->in_stock == 0){
            return redirect()->route('home');
        }
        $product->in_stock = $product->in_stock - $val;
        $product->timestamps = false;
        $product->save();
        $cart = DB::table('users_products_cart')
            ->where('product_id', '=', $product->id)
            ->where('user_id','=',Auth::id());
        $bool = $cart->first();
        if(is_null($bool)){
            $product->cart()->attach(auth()->user()->id, ['amount' => $val]);
        } else {
            $cart->update(['amount' => $bool->amount + $val]);
        }
        return redirect()->route('home')
            ->with('place_in_cart','null');
    }

    public function cancelCart($user) {
        $user = User::find($user);
        $products = $user->cart()->get();
        foreach ($products as $product) {
            $product->update(['in_stock' => $product->in_stock + $product->pivot->amount]);
            $product->cart()->detach($user->id);
        }
        return redirect()->route('home')
            ->with('cancel_cart', 'null');
    }

    public function cancelProduct(Request $request) {
        $cart = Auth::user()->cart()->where('product_id', '=', $request->id);
        $product = $cart->first();

        $product->update(['in_stock' => $product->in_stock + $request->amount]);
        if($product->pivot->amount == $request->amount){
            $product->cart()->detach(Auth::id());
        } else {
            $cart->update(['amount'=>$product->pivot->amount - $request->amount]);
        }

        return redirect()->back()
            ->with('cancel_product', 'null');
    }

    /**
     * Buys one item
     * @deprecated
     * @param $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buyItem(Request $request) {
        $email = auth()->user()->email;
        $cart = auth()->user()->cart()->where('product_id', '=', $request->id);
        $product = $cart->first();

        if($product->pivot->amount == $request->amount){
            $product->cart()->detach(Auth::id());
        } else {
            $cart->update(['amount'=>$product->pivot->amount - $request->amount]);
        }
        $myProducts = Auth::user()->products()->where('product_id', '=', $request->id);
        $bool = $myProducts->first();
        if(is_null($bool)){
            $product->users()->attach(auth()->user()->id, ['amount' => $request->amount]);
        } else {
            $myProducts->update(['amount'=>$bool->pivot->amount + $request->amount]);
        }

        Mail::to($email)->send(new ConfirmPurchase([$bool], auth()->user()));

        return redirect()->route('home')
            ->with('success_purchase_item','null');
    }

    public function buyAllItems($user) {
        $user = User::find($user);
        $products = $user->cart()->get();
        $productList = [];

        foreach ($products as $product) {
            array_push($productList, $product);
            $entity = Products::find($product->id);
            $entity->users()->attach(auth()->user()->id, ['amount' => $product->pivot->amount]);
            $entity->cart()->detach($user->id);
        }

        $email = auth()->user()->email;
        Mail::to($email)->send(new ConfirmPurchase($productList, auth()->user()));
        return redirect()->route('home')
            ->with('success_purchase', 'null');
    }
}
