<?php

namespace App\Http\Controllers\WebView;

use App\Models\BuyItem;
use App\Models\Product;
use App\Models\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BuyController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('webview.buy.buy', compact('product'));
    }

    public function buyNow(Request $request)
    {
        $product = Product::find($request->id);
        if (!$product) return back()->with('error', 'Product not found.');

        if (!$request->color || !$request->size)
            return back()->with('error', 'Please select color and size.');

        $buyItem = BuyItem::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'quantity' => 1,
                'price' => $product->sale_price ?? $product->regular_price,
                'image' => $product->image,
                'color' => $request->color,
                'size' => $request->size,
            ]
        );

        $ship = Shipping::all();
        return view('webview.buy.buy', compact('buyItem', 'ship'));
    }

    public function increasebuyquantity($rowId)
    {
        if ($item = BuyItem::find($rowId)) {
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

    public function decreasebuyquantity($rowId)
    {
        if ($item = BuyItem::find($rowId)) {
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





    // Wishlist page
    public function wiselist()
    {
        $buyItem = BuyItem::with('product')
            ->where('user_id', Auth::id())
            ->whereHas('product')
            ->get();

        $ship = Shipping::all();
        return view('webview.wishlist.wishlist', compact('buyItem', 'ship'));
    }

    // Remove item from wishlist
    public function removeWise($id)
    {
        if ($item = BuyItem::find($id)) {
            $item->delete();
        }
        return back();
    }

    // Empty wishlist
    public function emptyWise()
    {
        BuyItem::where('user_id', Auth::id())->delete();
        return redirect()->route('wiselist')->with('success', 'Wishlist cleared.');
    }
}
