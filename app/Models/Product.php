<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Brand;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
            'name'
    ];

    public function brands():HasMany
    {
        return $this->hasMany(Brand::class,'product_id');
    }
}
