<?php

namespace App\Http\Controllers\DashBoard;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Address;
use App\Models\BuyItem;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\CartDiscount;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\selecteditems;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function placeorder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user_id = Auth::id();

        // Validate the form data
        $request->validate([
            'province' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'local_level' => 'required|string|max:100',
            'local_level_type' => 'required|string|max:255',
            'road_area_colony' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'mode' => 'required|string|in:Wallet,COD,bank',
        ]);

        // Update existing default address or create new one
        $address = Address::updateOrCreate(
            ['user_id' => $user_id, 'isdefault' => true],
            [
                'province' => $request->province,
                'district' => $request->district,
                'local_level' => $request->local_level,
                'local_level_type' => $request->local_level_type,
                'road_area_colony' => $request->road_area_colony,
                'landmark' => $request->landmark ?? '',
                'isdefault' => true
            ]
        );
        $order = Order::all();

        // Create transaction
        $mode = $request->mode; // Wallet, COD, bank
        $wallet = $request->wallet_mode;

        Transaction::create([
            'order_id' => $order->id,
            'mode' => $mode,
            'wallet_mode' => $wallet,
            'status' => 'pending',
        ]);


        // Redirect based on payment mode
        if ($mode === 'Wallet') {
            return match ($wallet) {
                'e-sewa' => redirect('/payment/form'),
                'khalti' => redirect('/khalti-payment'),
                'nepal-pay' => redirect('/nepalpay-payment'),
                'namaste-pay' => redirect('/namastepay-payment'),
                default => redirect()->route('order.confirmation', ['order_id' => $order->id])
            };
        }

        $selectedItems = Selecteditems::where('user_id', $user_id)->get();
        foreach ($selectedItems as $item) {
            if ($item->source_type === 'cart') {
                CartItem::where('user_id', $user_id)
                    ->where('product_id', $item->product_id)
                    ->delete();
            } elseif ($item->source_type === 'wishlist') {
                BuyItem::where('user_id', $user_id)
                    ->where('product_id', $item->product_id)
                    ->delete();
            }
            $item->delete();
        }
        return redirect()->route('order.confirmation', ['order_id' => $order->id]);
    }

    // Order confirmation page
    public function orderConfirm($order_id)
    {
        $order = Order::find($order_id);
        if (!$order) {
            return redirect()->route('cart.index');
        }
        return view('webview.checkout.order-confirmation', compact('order'));
    }
    public function orders()
    {
        $orders = Order::orderBy('created_at', 'DESC')->paginate(12);
        return view('dashboard.pages.orders.orders', compact('orders'));
    }

    public function order_details($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::with(['product.category', 'product.brand'])
            ->where('order_id', $id)
            ->orderBy('id')
            ->get();
        $transaction = Transaction::where('order_id', $id)->first();
        return view('dashboard.pages.orders.order-details', compact('order', 'orderItems', 'transaction'));
    }


    public function showOrderStatusUpdateForm($id)
    {
        $order = Order::findOrFail($id);
        return view('dashboard.pages.orders.order-statusupdate', compact('order'));
    }
    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->input('status');
        if ($request->status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } elseif ($request->status == 'canceled') {
            $order->canceled_date = Carbon::now();
        } elseif ($request->status == 'pending') {
            $order->delivered_date = null;
            $order->canceled_date = null;
        }
        $order->save();
        $transaction = Transaction::where('order_id', $id)->first();
        if ($transaction) {
            if ($request->status == 'delivered') {
                $transaction->status = 'approved';
            } elseif ($request->status == 'canceled') {
                $transaction->status = 'declined';
            } elseif ($request->status == 'pending') {
                $transaction->status = 'pending';
            }
            $transaction->save();
        }

        return redirect()->route('orders')->with('status', 'Order status updated successfully');
    }

    public function downloadPDF($id)
    {
        $order = Order::with(['orderItems.product', 'transaction'])->findOrFail($id);
        $pdf = Pdf::loadView('webview.checkout.pdf', compact('order'));
        $filename = 'Order_' . $order->id . '.pdf';
        return $pdf->download($filename);
    }
}
