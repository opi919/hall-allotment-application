<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetails;
use App\Models\Bill;
use App\Models\Setting;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        // Redirect if already logged in as admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Check if user is admin
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'You do not have admin privileges.');
            }
        }

        return redirect()->route('admin.login')->with('error', 'Invalid credentials.');
    }

    public function dashboard()
    {
        // Get hall-wise statistics with proper joins and aggregations
        $hallStats = UserDetails::select('user_details.hall_name')
            ->selectRaw('COUNT(user_details.id) as total_applications')
            ->selectRaw('COUNT(CASE WHEN bills.payment_status = "1" THEN bills.id END) as paid_applications')
            ->selectRaw('COALESCE(SUM(CASE WHEN bills.payment_status = "1" THEN CAST(bills.amount AS DECIMAL(10,2)) END), 0) as total_revenue')
            ->leftJoin('bills', 'user_details.username', '=', 'bills.username')
            ->groupBy('user_details.hall_name')
            ->orderBy('total_applications', 'desc')
            ->get();

        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.dashboard', compact('hallStats', 'settings'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}
