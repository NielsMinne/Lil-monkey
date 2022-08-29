<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $with= ['shop','category'];

    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
}
