<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
 protected $guarded = [];

    // Define the relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
