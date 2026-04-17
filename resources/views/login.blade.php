@extends('layouts.app')
@section('title', 'Login - Hall Residency Application')
@section('content')
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div
            class="w-[500px] h-auto p-10 bg-white rounded-lg shadow-md flex flex-col justify-center mx-auto border border-gray-300">
            <img src="{{ asset('logo/logo.png') }}" alt="" width="80" class="mx-auto mb-5">
            <h1 class="text-[28px] font-bold text-[#2c3e50] text-center mb-[30px]">
                Login to Your Account
            </h1>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5 text-center"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf
                <div class=" mb-5">
                    <input type="text" name="internet_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Internet ID" required value="{{ old('internet_id') }}">
                    @error('internet_id')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class=" mb-5">
                    <input type="password" name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Password" required>
                    @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-[10px] bg-blue-600 hover:bg-blue-800 text-white font-semibold rounded-md transition duration-200">
                    Login
                </button>
            </form>

            {{-- <div class="text-center mt-3">
            <small class="text-gray-600">
                Forgot your password? <a href="#" class="text-blue-500 hover:underline">Reset it here</a>
            </small>
        </div> --}}
        </div>
    </div>
@endsection
