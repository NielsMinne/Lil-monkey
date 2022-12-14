<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Babylist extends Model
{
    use HasFactory;

    protected $with= ['user'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
}
