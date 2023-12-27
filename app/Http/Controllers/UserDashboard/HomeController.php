<?php

namespace App\Http\Controllers\UserDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;

class HomeController extends Controller
{
    public function home(Request $request)
    {   
        $items = Item::all();
        return view('user_dashboard',compact('items'));
    }
}
