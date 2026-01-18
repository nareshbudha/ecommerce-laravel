<?php

namespace App\Http\Controllers\DashBoard;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\BuyItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\selecteditems;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('expiry_date', 'DESC')->paginate(10);
        return view('dashboard.pages.coupons.coupons', compact('coupons'));
    }

    public function create()
    {
        return view('dashboard.pages.coupons.add-coupon');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'expiry_date' => 'required|date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        Coupon::create($request->only('code', 'type', 'value', 'expiry_date', 'usage_limit'));

        return redirect()->route('coupons.index')->with('status', 'Coupon has been added successfully');
    }

    public function edit(Coupon $coupon)
    {
        return view('dashboard.pages.coupons.edit-coupon', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'expiry_date' => 'required|date',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $coupon->update($request->only('code', 'type', 'value', 'expiry_date', 'usage_limit'));

        return redirect()->route('coupons.index')->with('status', 'Coupon has been updated successfully');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('status', 'Coupon has been deleted successfully');
    }



    // Discount calculation
    public function calculateDiscount($code = null)
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
        $taxRate = config('cart.tax', 0);
        $tax = ($subtotalAfter * $taxRate) / 100;
        $total = $subtotalAfter + $tax;

        return [
            'discount' => $discount,
            'subtotal' => $subtotalAfter,
            'tax' => $tax,
            'total' => $total,
            'coupon' => $coupon,
        ];
        $order = Order::update([
            'user_id' => $user_id,
            'subtotal' => $subtotalAfter,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,

        ]);
    }
    public function applycoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $userId = Auth::id();
        $code = $request->input('code');
        session()->forget('coupon');

        // Fetch coupon
        $coupon = Coupon::where('code', $code)
            ->where('expiry_date', '>=', Carbon::now())
            ->first();

        if (!$coupon) {
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        if ($coupon->usage_limit && $coupon->times_used >= $coupon->usage_limit) {
            return back()->with('error', 'This coupon has reached its usage limit.');
        }

        // Fetch current order(s) for the user
        $orders = Order::where('user_id', $userId)->get();

        if ($orders->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        // Calculate subtotal
        $subtotal = $orders->sum(fn($order) => $order->subtotal);

        // Calculate discount
        $discount = $coupon->type === 'fixed'
            ? $coupon->value
            : ($subtotal * $coupon->value) / 100;

        $subtotalAfter = max($subtotal - $discount, 0);
        $taxRate = 13; // VAT percentage
        $tax = ($subtotalAfter * $taxRate) / 100;
        $total = $subtotalAfter + $tax;

        // Update all orders for the user
        foreach ($orders as $order) {
            $order->update([
                'subtotal' => $subtotal,
                'discount' => $discount,
                'subtotalafterdiscount' => $subtotalAfter,
                'tax'      => $tax,
                'total'    => $total,

            ]);
        }
        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount,
            'subtotal' => $subtotalAfter,
            'tax' => $tax,
            'total' => $total
        ]]);
        $coupon->increment('times_used');
        return back()->with('success', 'Coupon applied successfully.');
    }


    public function remove(Request $request)
    {
        $couponData = session('coupon');
        if ($couponData) {
            $coupon = Coupon::find($couponData['id']);
            if ($coupon && $coupon->times_used > 0) {
                $coupon->decrement('times_used');
            }
            session()->forget('coupon');
        }
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->get();
        if ($orders->isNotEmpty()) {
            foreach ($orders as $order) {
                $subtotal = $order->subtotal;
                $tax = $order->tax;
                $order->update([
                    'discount' => 0,
                    'subtotalafterdiscount' => 0,
                    'total' => $subtotal + $tax
                ]);
            }
        }
        return back()->with('success', 'Coupon removed successfully.');
    }
}
