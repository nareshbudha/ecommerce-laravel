<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    protected $table = 'addresses';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

