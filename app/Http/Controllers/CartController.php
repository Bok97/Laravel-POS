<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request){
        if($request->wantsJson()){
            return response(
                $request->user()->cart()->get()
            );
        }
        return view('cart.index');
    }

    public function store(Request $request){
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);
        $id = $request->id;

        $cart = $request->user()->cart()->where('id', $request->id)->first();
        if ($cart) {
            // update only quantity
            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();
        } else {
            $product = Product::where('id', $id)->first();
            $request->user()->cart()->attach($product->id, ['quantity' => 1]);
        }

        return response('', 204);
    }

    public function addQty(Request $request){
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        $cart = $request->user()->cart()->where('id', $request->id)->first();
        if ($cart) {
            // update only quantity
            $cart->pivot->quantity = $cart->pivot->quantity + 1;
            $cart->pivot->save();
        } 

        return response('', 204);
    }

    public function minusQty(Request $request){
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        $cart = $request->user()->cart()->where('id', $request->id)->first();

        if($cart) {
            // update only quantity
            $cart->pivot->quantity = $cart->pivot->quantity - 1;
            $cart->pivot->save();
        }
        if($cart->pivot->quantity == '0'){
            $request->user()->cart()->detach($request->id);
        }
        return response('', 204);

    }


    public function changeQty(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $cart = $request->user()->cart()->where('id', $request->product_id)->first();

        if ($cart){
            $cart->pivot->quantity = $request->quantity;
            $cart->pivot->save();
        }

        return response([
            'success' => true
        ]);
    }

    public function delete(Request $request){
        $request->validate([
            'product_id' => 'required|integer|exists:products,id'
        ]);
        $request->user()->cart()->detach($request->product_id);

        return response('', 204);
    }

    public function empty(Request $request){
        $request->user()->cart()->detach();
        return response('', 204);
    }
}
