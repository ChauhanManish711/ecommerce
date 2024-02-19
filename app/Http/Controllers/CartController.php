<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
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
            if($item->quantity == 0)
            {
                //if Item is zero then return without adding to cart
                //it means item is out of stock
                return response()->json([
                    'message' => '2'
                ]);
            }
            //update quantity in item
            $decrese_quantity = $item->update(['quantity'=>$item->quantity - 1]);
            //find item from user cart
            $item_in_cart = Cart::where(['item_id'=>$item_id,'user_id'=>\Auth::user()->id])->first();
            if(isset($item_in_cart))
            {
                //set quantity for user item with adding 1
                $quantity = $item_in_cart->quantity + 1;
                //update quantity
                $update_cart = $item_in_cart->update(['quantity'=>$quantity]);
            }
            else{
                //if item not avaible in user item (user cart) then add
                // $add_cart =  Cart::create(['user_id'=>\Auth::user()->id,'item_id'=>$item_id,'quantity'=>1]);
                $user = \Auth::user();
                $user->carts()->attach($item_id,['quantity'=>1,"created_at"=> Carbon::now(),"updated_at"=> now()]);
            }
            //return success
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
            $item_id = $request->item_id;
            //step : 1  (find the item in cart and update the quantity into the cart)
            //find user cart 
            $user_item = Cart::where(['item_id'=>$item_id,'user_id'=>\Auth::user()->id])->first();
            //remove a quantity from user cart
            $user_item->update(['quantity'=>$user_item->quantity-1]);
            
            //step : 2 (Find the item in item table and update the quantity , because it remove from user cart table now)
            //find item in item table
            $item = Item::find($item_id);
            //add a quantity into Item table
            $item->update(['quantity'=>$item->quantity+1]);
            //fetch updated cart item
            if(isset($user_item) && $user_item->quantity == 0)
            {
                $user_item->delete();
                \Session::flash('success','A item is successfully removed from cart');
                return response()->json([
                    'location' => route('user_cart')
                ]);
            }

            //step : 3 (Get the items from user cart and calculate price etc and return the values)
            $cart = \Auth::user()->carts()->get();
            $quantity_total = 0;
            $price_total = 0;
            foreach($cart as $userItem)
            {
                $quantity_total += $userItem->pivot->quantity;
                $price_total += $userItem->pivot->quantity * $userItem->price;  
            }
            $data = [ 
                'quantity' => $user_item->quantity,
                'subtotal' => $user_item->quantity * $item->price,
                'quantity_total' => $quantity_total,
                'price_total' => $price_total
            ];
            return response()->json([
               'data'=>$data
            ]);
        }catch(\Exception $err)
        {
            return $err->getMessage();
        }

    } 
    //delete user item from cart
    public function delete_cart($item_id)
    {
        try{
            //step:1 (Find item and remove from user cart)
            $user_cart = Cart::where(['item_id'=>$item_id,'user_id'=>\Auth::user()->id])->first();
            $user_cart->delete();
            
            //step:2 (Find item from item table and update quantity)
            $item = Item::find($item_id);
            $item->update(['quantity'=>$item->quantity+$user_cart->quantity]);
            
            \Session::flash('success','Successfully deleted.');
            return redirect()->back();
        }catch(\Exception $err){
            Log::error(\Auth::user()->email.','.$err->getMessage());
            \Session::flash('error','Sorry,Something went wrong.');
            return redirect()->back();
        }
    }
}
