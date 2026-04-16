@extends('layouts.app')
@section('title', 'Student Dashboard')
@section('content')
    <div class="min-h-screen bg-gray-100 py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-4">

            @php
                $details = $userDetails ?? null;
            @endphp

            @if (!$details)
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded-xl">
                    No detailed profile information found.
                </div>
            @else
                <div>

                </div>
                <!-- Header -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Student Dashboard</h1>
                            <p class="text-gray-600 mt-1 text-sm sm:text-base">
                                Welcome back, {{ $userDetails->name }}
                            </p>
                        </div>
                        @if (App\Models\Setting::where('key', 'allow_application')->first()?->value)
                            <div class="flex gap-3">
                                <a href="{{ route('student.form.edit') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors">
                                    Edit Information
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

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

                <!-- Top Grid -->
                <div class="mb-2 sm:mb-4 pt-4 border-t grid grid-cols-1 gap-4 sm:gap-6">
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">
                            Bill Information</h2>
                        <div class="space-y-3 text-gray-700 text-sm sm:text-base">
                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500">Bill ID</span>
                                <span class="font-medium break-words">{{ $bill->bill_id ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500">Amount</span>
                                <span class="font-medium break-words">{{ $bill->amount . ' BDT' }}</span>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500 mb-2 lg:mb-0">Status</span>
                                <div>
                                    @if ($bill->payment_status != 1 && App\Models\Setting::where('key', 'allow_application')->first()?->value)
                                        <a href="{{ route('payment.init', $bill->id) }}"
                                            class="ml-4 px-6 py-2 bg-red-600 text-white rounded-lg text-sm font-medium mr-2">
                                            Pay Now
                                        </a>
                                    @endif

                                    <span
                                        class="px-3 py-1 rounded-lg text-sm font-medium
                                    {{ $bill->payment_status == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $bill->payment_status == 1 ? 'Paid' : 'Unpaid' }}
                                    </span>

                                    @if ($bill->payment_status == 1)
                                        <a href="{{ route('student.download-form') }}"
                                            class="ml-4 px-6 py-2 bg-green-600 text-white rounded-lg text-sm font-medium">
                                            Download PDF
                                        </a>
                                    @endif
                                </div>
                            </div>

                            @if ($bill->payment_status == 1)
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <span class="text-gray-500">Payment Date</span>
                                    <span
                                        class="font-medium break-words">{{ \Carbon\Carbon::parse($bill->payment_date)->format('F j, Y') }}</span>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <span class="text-gray-500">Payment Method</span>
                                    <span class="font-medium break-words">{{ $bill->payment_method ?? '-' }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                    <!-- Basic Info -->
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">Basic Information</h2>

                        <div class="space-y-3 text-gray-700 text-sm sm:text-base">

                            @foreach ([
            'Name' => $details->name,
            'Bangla Name' => $details->name_bangla,
            'Student ID' => $details->username,
            "Father's Name" => $details->fname,
            'Email' => $details->email,
            'Mobile' => $details->mobile,
        ] as $label => $value)
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <span class="text-gray-500">{{ $label }}</span>
                                    <span class="font-medium break-words">{{ $value ?? '-' }}</span>
                                </div>
                            @endforeach

                            <div class="pt-3 border-t">
                                <p class="text-sm text-gray-500">Emergency Contact</p>
                                <p class="font-medium break-words">
                                    {{ $details->emergency_contact_name ?? '-' }}<br>
                                    {{ $details->emergency_contact_no ?? '-' }}
                                    ({{ $details->emergency_contact_relation ?? '-' }})
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Academic -->
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                        <h2 class="text-lg sm:text-xl font-semibold mb-4 border-b pb-2">Academic & Residence</h2>

                        <div class="space-y-3 text-gray-700 text-sm sm:text-base">

                            @foreach ([
            'Faculty' => $details->faculty,
            'Department' => $details->department,
            'Session' => $details->session,
        ] as $label => $value)
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <span class="text-gray-500">{{ $label }}</span>
                                    <span class="break-words">{{ $value ?? '-' }}</span>
                                </div>
                            @endforeach

                            <!-- Current Year -->
                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500">Current Year</span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg w-fit">
                                    @if ($details->current_year && $details->current_year == 5)
                                        Master's
                                    @else
                                        {{ $details->current_year == 1 ? '1st Year' : ($details->current_year == 2 ? '2nd Year' : ($details->current_year == 3 ? '3rd Year' : ($details->current_year == 4 ? '4th Year' : $details->current_year . 'th Year'))) }}
                                    @endif
                                </span>
                            </div>

                            @if ($details->current_semester)
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <span class="text-gray-500">Semester</span>
                                    <span>
                                        {{ $details->current_semester == 1
                                            ? '1st Semester'
                                            : ($details->current_semester == 2
                                                ? '2nd Semester'
                                                : '3rd Semester') }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500">Hall</span>
                                <span>{{ $details->hall_name ?? '-' }}</span>
                            </div>

                            <!-- Addresses -->
                            <div class="pt-3 border-t space-y-2">
                                <div>
                                    <p class="text-sm text-gray-500">Permanent Address</p>
                                    <p class="break-words capitalize">{{ $details->permanent_address ?? '-' }}</p>
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">Present Address</p>
                                    <p class="break-words capitalize">{{ $details->present_address ?? '-' }}</p>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500">Relatives in Rajshahi</span>
                                <span class="capitalize">{{ $details->relatives_in_rajshahi ?? '-' }}</span>
                            </div>

                            <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                <span class="text-gray-500">Home in Rajshahi</span>
                                <span class="capitalize">{{ $details->is_home_in_rajshahi ?? '-' }}</span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Bottom Grid -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">

                    <!-- GPA -->
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                        <h3 class="text-lg font-semibold mb-4">GPA Overview</h3>

                        <div class="space-y-3 text-sm sm:text-base">
                            @foreach ([
            '1st Year GPA/YGPA' => $details->gpa_1_year,
            '2nd Year GPA/YGPA' => $details->gpa_2_year,
            '3rd Year GPA/YGPA' => $details->gpa_3_year,
            '4th Year GPA/YGPA' => $details->gpa_4_year,
        ] as $year => $gpa)
                                <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-1">
                                    <span>{{ $year }}</span>
                                    <span
                                        class="px-3 py-1 rounded-lg {{ $gpa ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} font-medium">
                                        {{ $gpa ?? '-' }}
                                    </span>
                                </div>
                            @endforeach
                            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-1">
                                <span>Last Highest GPA/SGPA/YGPA</span>
                                <span class="px-3 py-1 rounded-lg bg-green-100 text-green-700 font-medium">
                                    {{ $details->last_highest_gpa ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Certificates -->
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                        <h3 class="text-lg font-semibold mb-4">Certificates</h3>

                        <div class="space-y-3 text-sm sm:text-base">
                            @foreach (App\ExtraCurricular::cases() as $c)
                                <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center gap-2">
                                    <span>{{ $c->displayName() }}</span>

                                    <span
                                        class="px-3 py-1 rounded-lg text-sm font-medium capitalize
                                {{ $details->{$c->certificateField()} === 'yes' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $details->{$c->certificateField()} ?? '-' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="bg-white rounded-2xl shadow-sm p-4 sm:p-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Info</h3>

                        <div class="space-y-3 text-gray-700 text-sm sm:text-base">
                            <div>
                                <p class="text-sm text-gray-500">Emergency Relation</p>
                                <p>{{ $details->emergency_contact_relation ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Emergency Number</p>
                                <p>{{ $details->emergency_contact_no ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection
