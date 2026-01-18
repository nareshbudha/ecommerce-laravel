<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    // Define the $fillable array only once
    protected $guarded = [];

    // Define the relationship with categories (self-referential many-to-many)
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_category', 'category_id', 'sub_category_id');
    }

    // Define the relationship with subCategories
    public function subCategories()
    {
        return $this->belongsToMany(Category::class, 'category_category', 'sub_category_id', 'category_id');
    }

    // Define the relationship with products
    public function products()
    {
       return $this->hasMany(Product::class, 'category_id');
    }
}
