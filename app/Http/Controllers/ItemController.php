<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Item;
use Illuminate\Support\Facades\Session;
use App\Traits\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    use ActivityLogs;
    public function index(Request $request)
    {
        return view('admin.item');
    }
    //get products
    public function get_products(Request $request)
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ]);
    }
    //get brands
    public function get_brands(Request $request)
    {
        $brands = Brand::where('product_id',$request->id)->get();
        return response()->json([
            'brands' => $brands 
        ]);
    }
    //add item
    public function create_item(Request $request)
    {
        $request->validate([
            'item_name'  => 'required',
            'price'      => 'required',
            'product_id' => 'required',
            'brand_id'   => 'required',
            'quantity'   => 'required|integer',
            'description'=> 'required',
            'image'      => 'required'
        ],[
            'item_name.required'  =>'Name is required',
            'price.required'      =>'Price is required',
            'product_id.required' =>'Category is required',
            'brand_id.required'   =>'Brand is required',
            'description.required'=>'Description is required',
            'quantity.required'   =>'Quantity is required',
            'quantity.integer'    =>'Quantity must be in digitis.',
            'image.required'      =>'Image is required'
        ]);
        try{
            $brand = Brand::find($request->brand_id);
            $item = new Item();
            $item->name = $request->item_name;
            $item->price = $request->price;
            $item->description = $request->description;
            $item->quantity = $request->quantity;
            //save data
            $item = $brand->items()->save($item);
            //image 
            $image_name = time().'.'.$request->image->getClientOriginalExtension();
            //save image into images path
            $request->image->move(public_path('images'),$image_name);
            //image detail
            $image_detail = [
            'image'   => $image_name,
            ];

            //save image
            $image = $item->image()->create($image_detail);
            if(isset($image->id))
            {   
                $this->activity(Auth::user()->name,Auth::user()->email,''.$request->item_name.' item is added','success' );
                Session::flash('success',''.ucfirst($request->item_name).' is added successfully');
                return response()->json([
                    'location'  => route('add.items')
                ]);
            }
            Session::flash('error',''.ucfirst($request->item_name).' is not added successfully');
            return response()->json([
                'location'  => route('add.items')
            ]);
        }
        catch(\Exception $e)
        {
            $this->activity(Auth::user()->name,Auth::user()->email,'item may added but,'.$e->getMessage(),'error');
            Session::flash('error',$e->getMessage());
            return response()->json([
                'location'  => route('add.items')
            ]);
        }
    }
    //fetch single item
    public function get_item(Request $request)
    {
        $item = Item::find($request->item_id);
        $image = $item->image->image;
        return response()->json(
            ['item'=>$item , 'image'=>$image]
        );
    }
    //delete item
    public function delete_item(Request $request)
    {
        try{
        $item_id = $request->item_id;
        $item = Item::find($item_id);
        // $delete_image = $item->image->delete();
        // if($delete_image == true)
        // {
            $item->delete();
            Session::flash('success',''.$item->name.' is successfully delete');
            return response()->json([
                'redirect' => route('products.all')
            ]);
        // }
        }
        catch(\Exception $err)
        {
            return response()->json([
                'err'=>$err->getMessage()
            ]);
        }   
    }
    //edit item
    public function edit_item(Request $request ,$item_id)
    {
        $item = Item::find($item_id);

        //image 
        $image = $item->image()->first();
        //brand
        $brand = $item->brands()->first();
        //category
        $category = $brand->product()->first();
        //all_Categories
        $all_categories = Product::all();

        //brands related to category
        $all_brands = $category->brands()->get();

        return view('admin.item',compact('item','category','all_categories','all_brands','brand','image'));
    }
    //updating item
    public function update_item(Request $request)
    {
            $request->validate([
                'id'=>'required',
                'item_name' => 'required',
                'price' => 'required',
                'product_id' => 'required',
                'brand_id'=> 'required',
                'description'   => 'required'
            ]); 
          //if validation pass   
            $updated_info = [
                'name' => $request->item_name, 'price'=> $request->price,
                'brand_id' => $request->brand_id,'description'=>$request->description
            ];
        //item
        $item = Item::find($request->id);
        //update item
        $update_item = $item->update($updated_info);

        if(isset($request->image))
        {
            //get image name
            $image_name = time().'.'.$request->image->getClientOriginalExtension();

            //save image into images path with name
            $request->image->move(public_path('images'),$image_name);

            //image detail
            $image_detail = [
            'image'   => $image_name,
            ];

            //update image
            $item->image()->update($image_detail);
        }
        Session::flash('success',ucfirst($item->name)." is successsfully update");  
        return response()->json(['location'=>route('products.all')]);
    }   
}
