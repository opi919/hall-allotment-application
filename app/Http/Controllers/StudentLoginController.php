<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StudentLoginController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect()->intended('/student/dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'internet_id' => 'required|string|size:10',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('internet_id', 'password');

        $response = self::verify($credentials);

        if ($response['error_code'] !== 0) {
            return back()->withErrors([
                'internet_id' => 'Invalid credentials.',
            ])->withInput();
        }

        //check if user exists in database, if not create a new user
        $user = User::where('username', $credentials['internet_id'])->first();
        $user = User::createOrUpdate(
            ['username' => $credentials['internet_id']],
            [
                'name' => $response['name'],
                'designation' => $response['designation'],
                'department' => $response['department'],
                'password' => $credentials['password'],
            ]
        );

        if (auth()->attempt(['username' => $credentials['internet_id'], 'password' => $credentials['password']])) {
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'internet_id' => 'Invalid credentials.',
        ]);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function verify($credentials)
    {
        $url = config('app.verify.url');
        $key = config('app.verify.key');

        $username = $credentials['internet_id'];
        $password = $credentials['password'];

        Log::info('Sending verification request', ['url' => $url, 'key' => $key, 'username' => $username]);

        $request_data = [
            'key' => $key,
            'ru_user' => $username,
            'ru_pass' => $password,
        ];

        $request_data_encoded = base64_encode(json_encode($request_data));
        $response = Http::post($url, ['request' => $request_data_encoded]);

        $response = Http::withBody($request_data_encoded, 'text/plain')->post($url);

        $response_array = json_decode(base64_decode($response->body()), true);
        return $response_array;
    }
}
