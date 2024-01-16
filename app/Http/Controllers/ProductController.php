<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Item;
use DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        return view('admin.products',compact('products'));
    }
    public function all_products(Request $request)
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ]);
    }
    //get specfic product all records
    public function items(Request $request){
        $items = Item::join('brands','items.brand_id' ,'=','brands.id')
                        ->join('products','products.id','=', 'brands.product_id')
                        ->select('items.id', 'items.name', 'items.price', 'items.brand_id', 'items.quantity', 'products.id AS product_id', 'products.name AS product_name')
                        ->orderBy('items.id', 'desc');
        //when fetch records according to brand
        if(isset($request->brand_id))
        {
            $items = $items->where('brand_id',$request->brand_id);
        }
        //for searching
        if(isset($request->search))
        {
            //seraching records
            $items->where(function ($query) use($request) {
                    $query->where(DB::raw('CAST(items.price AS VARCHAR)'), 'LIKE', '%'.$request->search.'%')
                        ->orWhere('items.name','LIKE','%'.$request->search.'%')
                        ->orWhere('products.name', 'LIKE', '%'.$request->search.'%');
                });
        }
        //paginate
        $data = $items->paginate(5);  
        return response()->json([
            'data' => $data,
        ]);
    }
}
