<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    // Fillable property to allow mass assignment
    protected $guarded = [];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the OrderItem model
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Define the relationship with the Transaction model
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
    
}
