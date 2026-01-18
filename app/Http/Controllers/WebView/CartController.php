<?php

namespace App\Http\Controllers\WebView;

use App\Models\Address;
use App\Models\BuyItem;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\selecteditems;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display cart contents
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->whereHas('product')
            ->get();

        return view('webview.cart.cart', compact('items'));
    }

    // Add item to cart
    public function addCart(Request $request)
    {
        $userId = Auth::id();
        $product = Product::find($request->id);

        if (!$product) {
            return back()->with('error', 'Product not found.');
        }

        if (!$request->size || !$request->color) {
            return back()->with('error', 'Please select color and size.');
        }

        $cartItem = CartItem::firstOrNew([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = 1;
        $cartItem->price = $product->sale_price ?? $product->regular_price;
        $cartItem->image = $request->image;
        $cartItem->color = $request->color;
        $cartItem->size = $request->size;
        $cartItem->save();

        return back()->with('success', 'Product added to cart!');
    }
    public function increaseQuantity($id)
    {
        if ($item = CartItem::find($id)) {
            $item->increment('quantity');
        }
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'quantity' => $item->quantity,
                'subtotal' => $item->price * $item->quantity,
            ]);
        }

        return back();
    }

    public function decreaseQuantity($id)
    {
        if ($item = CartItem::find($id)) {
            if ($item->quantity > 1) {
                $item->decrement('quantity');
            }
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'quantity' => $item->quantity,
                'subtotal' => $item->price * $item->quantity,
            ]);
        }

        return back();
    }



    // Remove item
    public function removeItem($id)
    {
        if ($item = CartItem::find($id)) {
            $item->delete();
        }
        return back();
    }

    // Empty cart
    public function emptyCart()
    {
        CartItem::where('user_id', Auth::id())->delete();
        return redirect()->route('cart.index')->with('success', 'Cart emptied.');
    }


    public function checkout(Request $request)
    {
        $user = Auth::user();
        $address = Address::where('user_id', $user->id)
            ->where('isdefault', 1)
            ->first();

        // Get selected item IDs
        $selectedIds = $request->input('items', []);

        // Fetch selected cart items
        $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        // Fetch selected buy-now items
        $buyItems = BuyItem::with('product')
            ->where('user_id', $user->id)
            ->whereIn('id', $selectedIds)
            ->get();

        // Process cart items
        foreach ($cartItems as $item) {
            $order = Order::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'subtotal' => $item->price * $item->quantity,
                    'discount' => 0,
                    'tax' => ($item->price * $item->quantity) * 0.13,
                    'total' => ($item->price * $item->quantity) * 1.13,
                ]
            );

            $orderItem = OrderItem::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                ],
                [
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'color' => $item->color ?? null,
                    'size' => $item->size ?? null,
                    'source_type' => 'cart',
                ]
            );

            // Delete cart item after creating order item
            if ($orderItem->source_type === 'cart') {
                $item->delete();
            }
        }

        // Process buy-now items
        foreach ($buyItems as $item) {
            $order = Order::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'subtotal' => $item->price * $item->quantity,
                    'discount' => 0,
                    'tax' => ($item->price * $item->quantity) * 0.13,
                    'total' => ($item->price * $item->quantity) * 1.13,
                ]
            );

            $orderItem = OrderItem::updateOrCreate(
                [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                ],
                [
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'color' => $item->color ?? null,
                    'size' => $item->size ?? null,
                    'source_type' => 'wishlist',
                ]
            );

            // Delete buy-now item after creating order item
            if ($orderItem->source_type === 'wishlist') {
                $item->delete();
            }
        }

        // Retrieve all orders for the user
        $items = Order::where('user_id', $user->id)->get();

        // Calculate subtotal
        $subtotal = $items->sum(fn($i) => $i->subtotal);


        $coupon = session('coupon');
        if ($coupon) {
            $discount = $coupon['discount'];
            $subtotalAfterDiscount = $coupon['subtotal'];
            $vat = $coupon['tax'];
            $total = $coupon['total'];
        } else {
            $discount = 0;
            $subtotalAfterDiscount = $subtotal;
            $vatRate = 13; // VAT percentage
            $vat = ($subtotalAfterDiscount * $vatRate) / 100;
            $total = $subtotalAfterDiscount + $vat;
        }


        return view('webview.checkout.checkout', compact(
            'user',
            'address',
            'items',
            'subtotal',
            'vat',
            'total',
            'discount',
            'subtotalAfterDiscount'
        ));
    }
}
