    @extends('layouts.app')

    @section('content')
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">Student Dashboard</h1>

            <p class="text-lg mb-4">Welcome, {{ $user->name ?? 'Student' }}!</p>

            <!-- Resolve user details from a few possible variable shapes -->
            @php
                $details = null;
                if (isset($userDetails)) {
                    $details = $userDetails;
                } elseif (isset($user) && isset($user->userDetails)) {
                    $details = $user->userDetails;
                } elseif (isset($user) && isset($user->details)) {
                    $details = $user->details;
                } elseif (isset($userDetail)) {
                    $details = $userDetail;
                }
            @endphp

            @if (!$details)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                    <p class="text-yellow-700">No detailed profile information found.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h2 class="text-2xl font-semibold mb-4">Basic Information</h2>
                        <dl class="grid grid-cols-1 gap-y-3 text-gray-700">
                            <div class="flex justify-between">
                                <dt class="font-medium">Name</dt>
                                <dd>{{ $details->name ?? ($user->name ?? '-') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Name (Bangla)</dt>
                                <dd>{{ $details->name_bangla ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Username</dt>
                                <dd>{{ $details->username ?? ($user->username ?? '-') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Father's Name</dt>
                                <dd>{{ $details->fname ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Email</dt>
                                <dd>{{ $details->email ?? ($user->email ?? '-') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Mobile</dt>
                                <dd>{{ $details->mobile ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Emergency Contact</dt>
                                <dd>{{ $details->emergency_contact_name ?? '-' }} /
                                    {{ $details->emergency_contact_no ?? '-' }}
                                    ({{ $details->emergency_contact_relation ?? '-' }})</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h2 class="text-2xl font-semibold mb-4">Academic & Residence</h2>
                        <dl class="grid grid-cols-1 gap-y-3 text-gray-700">
                            <div class="flex justify-between">
                                <dt class="font-medium">Faculty</dt>
                                <dd>{{ $details->faculty ?? ($faculty ?? '-') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Department</dt>
                                <dd>{{ $details->department ?? ($department ?? '-') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Session</dt>
                                <dd>{{ $details->session ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Current Year</dt>
                                <dd>{{ $details->current_year ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Current Semester</dt>
                                <dd>{{ $details->current_semester ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Hall Name</dt>
                                <dd>{{ $details->hall_name ?? ($hall_name ?? '-') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Permanent Address</dt>
                                <dd class="text-right max-w-xs break-words">{{ $details->permanent_address ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Present Address</dt>
                                <dd class="text-right max-w-xs break-words">{{ $details->present_address ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Relatives in Rajshahi</dt>
                                <dd>{{ $details->relatives_in_rajshahi ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="font-medium">Is Home in Rajshahi</dt>
                                <dd>{{ $details->is_home_in_rajshahi ?? '-' }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-3">GPAs</h3>
                        <ul class="text-gray-700 space-y-2">
                            <li><strong>1st Year:</strong> {{ $details->gpa_1st_year ?? '-' }}</li>
                            <li><strong>2nd Year:</strong> {{ $details->gpa_2nd_year ?? '-' }}</li>
                            <li><strong>3rd Year:</strong> {{ $details->gpa_3rd_year ?? '-' }}</li>
                            <li><strong>4th Year:</strong> {{ $details->gpa_4th_year ?? '-' }}</li>
                        </ul>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-3">Certificates</h3>
                        <ul class="text-gray-700 space-y-2">
                            @php
                                $certs = [
                                    [
                                        'label' => 'International',
                                        'flag' => 'international_certificate',
                                        'path' => 'international_certificate_path',
                                    ],
                                    [
                                        'label' => 'National',
                                        'flag' => 'national_certificate',
                                        'path' => 'national_certificate_path',
                                    ],
                                    [
                                        'label' => 'University',
                                        'flag' => 'university_certificate',
                                        'path' => 'university_certificate_path',
                                    ],
                                    [
                                        'label' => 'Journalism',
                                        'flag' => 'journalism_certificate',
                                        'path' => 'journalism_certificate_path',
                                    ],
                                    [
                                        'label' => 'BNCC',
                                        'flag' => 'bncc_certificate',
                                        'path' => 'bncc_certificate_path',
                                    ],
                                    [
                                        'label' => 'Rover/Scout',
                                        'flag' => 'roverscout_certificate',
                                        'path' => 'roverscout_certificate_path',
                                    ],
                                ];
                            @endphp

                            @foreach ($certs as $c)
                                <li class="flex items-center justify-between">
                                    <span>{{ $c['label'] }}</span>
                                    <span class="text-right">
                                        @if (!empty($details->{$c['path']}) && !empty($details->{$c['flag']}))
                                            <a target="_blank" rel="noopener" class="text-indigo-600 hover:underline"
                                                href="{{ asset($details->{$c['path']}) }}">View</a>
                                        @elseif (!empty($details->{$c['flag']}))
                                            <span class="text-green-600">Provided</span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-3">Other</h3>
                        <ul class="text-gray-700 space-y-2">
                            <li><strong>Emergency Contact Relation:</strong>
                                {{ $details->emergency_contact_relation ?? '-' }}</li>
                            <li><strong>Emergency Contact No:</strong> {{ $details->emergency_contact_no ?? '-' }}</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>

    @endsection
