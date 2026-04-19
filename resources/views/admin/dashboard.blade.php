@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 py-6">

            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Admin Dashboard</h1>
                        <p class="text-gray-600 mt-1">
                            Welcome back, {{ Auth::user()->name ?? 'Administrator' }}
                        </p>
                    </div>
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
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

            <!-- Dashboard Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Applications Submitted -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Applications</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\UserDetails::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Bills Generated -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Bills Generated</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Bill::count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Bill Paid</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ \App\Models\Bill::where('payment_status', 1)->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                ৳{{ number_format(\App\Models\Bill::where('payment_status', 1)->sum('amount') - 5 * \App\Models\Bill::where('payment_status', 1)->count(), 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hall-wise Statistics -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">Hall-wise Application Statistics</h3>

                @if ($hallStats->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Hall Name</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Applications</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Paid Applications</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pending</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Revenue</th>
                                    <th
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($hallStats as $stat)
                                    @php
                                        $paymentRate =
                                            $stat->total_applications > 0
                                                ? ($stat->paid_applications / $stat->total_applications) * 100
                                                : 0;
                                        $pending = $stat->total_applications - $stat->paid_applications;
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900">{{ $stat->hall_name }}</div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $stat->total_applications }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $stat->paid_applications }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pending > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                                {{ $pending }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <span class="text-sm font-medium text-gray-900">
                                                ৳{{ number_format($stat->total_revenue - 5 * $stat->paid_applications, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center">
                                                <div class="w-full bg-gray-200 rounded-full h-2 mr-2 max-w-[60px]">
                                                    <div class="bg-{{ $paymentRate >= 75 ? 'green' : ($paymentRate >= 50 ? 'yellow' : 'red') }}-600 h-2 rounded-full"
                                                        style="width: {{ $paymentRate }}%"></div>
                                                </div>
                                                <span
                                                    class="text-xs font-medium text-gray-700">{{ number_format($paymentRate, 1) }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <p class="text-gray-500 text-lg">No applications submitted yet</p>
                        <p class="text-gray-400 text-sm mt-1">Statistics will appear here once students start submitting
                            applications</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
