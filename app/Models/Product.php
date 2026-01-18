<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

     protected $guarded = [];
   protected $casts = [
    'variants' => 'array',
    'images' => 'array',
];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Define the relationship with the SubCategory model
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    // Define the relationship with the Brand model
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function reviews()
{
    return $this->hasMany(Review::class);
}
public function coupon()
{
    return $this->belongsTo(Coupon::class);
}

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

}
