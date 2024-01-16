<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name','brand_id','price','description','quantity'
    ];

    public function brands():BelongsTo
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }
    public function users()
    {
        return $this->belongsToMany(Item::class,'user_item');
    }
}
