<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name','product_id'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function items():HasMany
    {
        return $this->hasMany(Item::class,'brand_id');
    }
}
