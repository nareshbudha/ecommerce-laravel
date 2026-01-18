<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyItem extends Model
{
    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
