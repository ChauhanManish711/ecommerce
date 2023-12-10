<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activitylog;

class ActivityController extends Controller
{
    public function all_activities(Request $request)
    {
        $activities = Activitylog::orderBy('id', 'DESC')->paginate('10');
        return view('activity',compact('activities'));
    }
}
