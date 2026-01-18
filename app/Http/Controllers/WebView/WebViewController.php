<?php

namespace App\Http\Controllers\WebView;

use App\Models\Order;
use App\Models\Address;
use App\Models\BuyItem;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WebViewController extends Controller
{
    public function myAccount()
    {
        return view('webview.account.my-account');
    }

    public function accountAddress(Request $request)
    {
        $user = Auth::user();
        $address = $user->address;

        if ($request->isMethod('post')) {
            // Validate the address input
            $request->validate([

                'mobile_num' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'district' => 'required|string|max:255',
                'town_city' => 'required|string|max:255',
                'house_no_building' => 'required|string|max:255',
                'road_area_colony' => 'required|string|max:255',
                'landmark' => 'nullable|string|max:255',
            ]);

            // Check if the user has an address
            if ($address) {
                // Update the existing address
                $address->update([

                    'mobile_num' => $request->mobile_num,
                    'state' => $request->state,
                    'district' => $request->district,
                    'town_city' => $request->town_city,
                    'house_no_building' => $request->house_no_building,
                    'road_area_colony' => $request->road_area_colony,
                    'landmark' => $request->landmark,
                    'isdefault' => true,
                ]);
            } else {
                // Create a new address
                $address = Address::create([
                    'user_id' => $user->id,
                    'mobile_num' => $request->mobile_num,
                    'state' => $request->state,
                    'district' => $request->district,
                    'town_city' => $request->town_city,
                    'house_no_building' => $request->house_no_building,
                    'road_area_colony' => $request->road_area_colony,
                    'landmark' => $request->landmark,
                    'isdefault' => true,
                ]);
            }

            return redirect()->route('account.details')->with('status', 'Address updated successfully');
        }

        return view('webview.account.account-address', compact('user', 'address'));
    }

    public function accountAddressAdd()
    {
        return view('webview.account.account-address-add');
    }

    public function accountDetails()
    {
        $user = Auth::user();

        // Check if the user type is 'user'
        if (strtolower($user->Usertype) == 'user') {
            $address = $user->address;
            return view('webview.account.account-details', compact('user', 'address'));
        } else {
            // Redirect to a different page or show an error message
            return redirect()->route('home.index')->with('error', 'You do not have permission to view this page.');
        }
    }

    public function accountOrderDetails($id)
    {
        $order = Order::find($id);
        $orderItems = OrderItem::with(['product.category', 'product.brand'])
            ->where('order_id', $id)
            ->orderBy('id')
            ->get();

        $transaction = Transaction::where('order_id', $id)->first();
        return view('webview.account.account-orders-details', compact('order', 'orderItems', 'transaction'));
    }

    public function accountOrder()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();

        // Fetch related order items and transactions for each order
        foreach ($orders as $order) {
            $order->items = OrderItem::where('order_id', $order->id)->get();
            $order->transaction = Transaction::where('order_id', $order->id)->first();
        }

        return view('webview.account.account-orders', compact('user', 'orders'));
    }

    public function accountReview()
    {
        return view('webview.account.account-review');
    }

    public function user_passwordreset()
    {
        return view('auth.passwords.email');
    }

    public function contact()
    {
        return view('webview.contact.contact');
    }

    public function about()
    {
        return view('webview.about.about');
    }
}
