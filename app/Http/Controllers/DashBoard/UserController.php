<?php
namespace App\Http\Controllers\DashBoard;
use App\Models\User;
use App\Http\Controllers\Controller; // Ensure the User model is imported

class UserController extends Controller
{
    public function showUsers()
    {
        // Optionally, paginate users to avoid performance issues with large data
        $users = User::paginate(10); // Change pagination number as needed

        // Pass the users to the view
        return view('dashboard.pages.users.users', ['users' => $users]);
    }
}
