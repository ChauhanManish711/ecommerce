<?php
use App\Models\Mobile;
//get model
function get_model($model){
    $get_model = [
        'mobiles' => Mobile::class,
        'watches' => Watch::class,
        'tvs'     => TV::class
    ];
    if(isset($get_model[$model])){
        return $get_model[$model];
    }
    return null;
}
?>