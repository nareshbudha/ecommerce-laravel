<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\BuyItem;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartDiscount
{
    public static function calculate($code = null)
    {
        $userId = Auth::id();

        $items = CartItem::where('user_id', $userId)->get()
            ->concat(BuyItem::where('user_id', $userId)->get());

        $subtotal = $items->sum(fn($i) => $i->price * $i->quantity);
        $discount = 0;
        $coupon = null;

        if ($code) {
            $coupon = Coupon::where('code', $code)
                ->where('expiry_date', '>=', Carbon::now())
                ->first();

            if ($coupon) {
                $discount = $coupon->type === 'fixed'
                    ? $coupon->value
                    : ($subtotal * $coupon->value) / 100;
            }
        }

        $subtotalAfter = max($subtotal - $discount, 0);
        $taxRate = 13; // 13% VAT
        $tax = ($subtotalAfter * $taxRate) / 100;
        $total = $subtotalAfter + $tax;

        return [
            'discount' => $discount,
            'subtotal' => $subtotalAfter,
            'tax' => $tax,
            'total' => $total,
            'coupon' => $coupon,
        ];
    }
}
