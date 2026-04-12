@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full mx-4">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-16 h-16 mx-auto mb-4">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h1>
                    <p class="text-gray-600">Sign in to access the admin dashboard</p>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-xl mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-300 text-red-800 p-4 rounded-xl mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                    @csrf

                    <!-- Username Field -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors"
                            placeholder="Enter your username" value="{{ old('username') }}">
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-colors"
                            placeholder="Enter your password">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-xl transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sign In
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 text-sm transition-colors">
                        ← Back to Home
                    </a>
                </div>

                <!-- Student Login Link -->
                <div class="mt-4 text-center">
                    <p class="text-gray-600 text-sm">
                        Are you a student?
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            Student Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
