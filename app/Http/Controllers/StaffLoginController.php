<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffLoginController extends Controller
{  public function index()
    
    {
        Artisan::call('check:stock');
        // Run the stock check command to get the low stock alert
        $lowStockAlert = Artisan::output();

        // Pass the lowStockAlert variable to the view
        return view('staff.index', ['lowStockAlert' => $lowStockAlert]);
    }

    public function showLoginForm()
    {
        // Check if the user is already logged in
        if (auth()->check()) {
            return redirect()->route('staff.index');
        }

        return view('auth.stafflogin');
    }

    public function login(Request $request)
    {
        // Check if there is an authenticated admin user and log them out
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $credentials = $request->only('email', 'password');

        // Check if the provided credentials match the default staff account
        if ($credentials['email'] === 'staff@gmail.com' && $credentials['password'] === '12345') {
            // Manually log in the user
            auth()->loginUsingId(1); // Use the user's ID or any other identifier

            // Redirect to the staff.index page
            return redirect()->route('staff.index');
        }

        // If login fails, redirect back to the login form with an error message
        return redirect()->route('staff.login')->with('error', 'Invalid credentials');

}
}