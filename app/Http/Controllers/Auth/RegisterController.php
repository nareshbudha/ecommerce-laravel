<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     */
    public function register(Request $request)
    {
        // Validate the request
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Create the user
        $user = $this->create($request->all());

        // Automatically log in the user
        Auth::login($user);
        // Redirect to home page
        return redirect()->route('home.index')
            ->with('status', 'Registration successful!');
    }

    /**
     * Validate incoming registration data.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile_num' => ['nullable', 'numeric', 'digits_between:8,13'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after registration.
     */
    protected function create(array $data)
    {
        $imagePath = null;
        if (isset($data['image'])) {
            $file = $data['image'];
            $fileName = time() . '-' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('user_images', $fileName, 'public');
        }
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'image' => $imagePath,
            'mobile_num' => $data['mobile_num'] ?? null,
            'password' => Hash::make($data['password']),
            'Usertype' => 'User',
        ]);
    }
}
