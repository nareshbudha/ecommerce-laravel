<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
protected $table = 'coupons';
    protected $guarded=[];
      public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('used_at');
    }

    public function isExpired()
    {
        return $this->expiry_date < now();
    }

    public function isUsageLimitReached()
    {
        return $this->usage_limit && $this->times_used >= $this->usage_limit;
    }
}
