<?php
namespace App\Traits;
use App\Models\Activitylog;

trait ActivityLogs{
    public function activity($name , $email , $operation,$status){
        $activity = new Activitylog();
        $activity->name = $name;
        $activity->email = $email;  
        $activity->operation = $operation;
        $activity->status = $status;
        $activity->save();
    }
}
?>