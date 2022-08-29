<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $with= ['babylist'];

    public function babylist()
    {
        return $this->belongsTo(Babylist::class,'list_id');
    }
}
