<?php
namespace App\Http\Controllers\WebView;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        $user_id = Auth::id();

        // Validate the form data
        $request->validate([
            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'town_city' => 'required|string|max:100',
            'house_no_building' => 'required|string|max:255',
            'road_area_colony' => 'required|string|max:255',
            'landmark' => 'nullable|string|max:255',
        ]);

        // Update existing default address or create new one
        $address = Address::updateOrCreate(
            ['user_id' => $user_id, 'isdefault' => true],
            [
                'state' => $request->state,
                'district' => $request->district,
                'town_city' => $request->town_city,
                'house_no_building' => $request->house_no_building,
                'road_area_colony' => $request->road_area_colony,
                'landmark' => $request->landmark ?? '',
                'isdefault' => true
            ]
        );
    }
}
