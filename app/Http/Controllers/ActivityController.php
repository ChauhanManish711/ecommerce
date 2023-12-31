<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activitylog;
use Illuminate\Support\Facades\Bus;

class ActivityController extends Controller
{
    public function all_activities(Request $request)
    {
        $activities = Activitylog::orderBy('id', 'DESC')->paginate('10');
        $batch = null;
        if(isset($request->batch_id))
        {
            $batch_id = $request->batch_id;
            $batch = Bus::findBatch($batch_id);
        }
        return view('activity',compact('activities','batch'));
    }
}
