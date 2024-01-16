<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
class CartController extends Controller
{
    //cart page
    public function user_cart(Request $request)
    {
        $user_cart = \Auth::user()->carts()->get();
        $quantity_total = 0;
        $total_price = 0;
        foreach($user_cart as $cart)
        {
            $quantity_total+= $cart->pivot->quantity;
            $total_price += $cart->price * $cart->pivot->quantity;
        }
        return view('user_dashboard.user_cart',compact('user_cart','quantity_total','total_price'));
    }
    // User add item to cart
    public function add_cart(Request $request)
    {
        try{
            $item_id = $request->item_id;
            $item = Item::find($request->item_id);
            $item_in_cart = Cart::where(['item_id'=>$item_id,'user_id'=>\Auth::user()->id])->first();
            if($item->quantity == 0)
            {
                return response()->json([
                    'message' => '2'
                ]);
            }
            $new_item_quantity = $item->quantity - 1;
            if($new_item_quantity >=0)
            {
                $decrese_quantity = $item->update(['quantity'=>$new_item_quantity]);
                if(isset($item_in_cart))
                {
                    $quantity = $item_in_cart->quantity + 1;
                    $update_cart = $item_in_cart->update(['quantity'=>$quantity]);
                }
                else{
                    $add_cart =  Cart::create(['user_id'=>\Auth::user()->id,'item_id'=>$item_id,'quantity'=>1]);
                }
            }
            return response()->json([
                'message' => '1'
            ]);
        }catch(\Exception $e)
        {
            \Log::error($e->getMessage());
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }
    // User remove item from cart
    public function remove_item(Request $request)
    {
        try{
            $user_item_id = $request->user_item_id;
            $user_item = Cart::find($user_item_id);
            $user_item->update(['quantity'=>$user_item->quantity-1]);
            $updated_user_item = Cart::find($user_item_id);
            $item = Item::find($updated_user_item->item_id);
            $cart = \Auth::user()->carts()->get();
            $quantity_total = 0;
            $price_total = 0;
            foreach($cart as $user_item)
            {
                $quantity_total+= $user_item->pivot->quantity;
                $price_total += $user_item->pivot->quantity * $user_item->price;   
            }
            return response()->json([
                'quantity' => $updated_user_item->quantity,
                'subtotal' => $updated_user_item->quantity * $item->price,
                'quantity_total' => $quantity_total,
                'price_total' => $price_total
            ]);
        }catch(\Exception $err)
        {
            return $err->getMessage();
        }

    } 
}
