@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-8">
        @if ($errors->has('gpa_1st_year'))
            <div class="max-w-5xl mx-auto p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-2">
                <strong>GPA Error:</strong> {{ $errors->first('gpa_1st_year') }}
            </div>
        @endif
        @if ($errors->has('gpa_2nd_year'))
            <div class="max-w-5xl mx-auto p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-2">
                <strong>GPA Error:</strong> {{ $errors->first('gpa_2nd_year') }}
            </div>
        @endif
        @if ($errors->has('gpa_3rd_year'))
            <div class="max-w-5xl mx-auto p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-2">
                <strong>GPA Error:</strong> {{ $errors->first('gpa_3rd_year') }}
            </div>
        @endif
        @if ($errors->has('gpa_4th_year'))
            <div class="max-w-5xl mx-auto p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-2">
                <strong>GPA Error:</strong> {{ $errors->first('gpa_4th_year') }}
            </div>
        @endif

        <form method="POST" action="{{ route('student.form.update') }}" enctype="multipart/form-data"
            class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-2xl space-y-6">
            @csrf
            @method('PUT')

            <div class="flex justify-between items-center mb-6">
                <h5 class="text-2xl font-bold">Edit Hall Application Form</h5>
                <a href="{{ route('student.dashboard') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-center">
                    Back to Dashboard
                </a>
            </div>

            <!-- Basic Info -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" placeholder="Username"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $userDetails->username ?? old('username') }}" readonly>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Name (English)<span class="text-red-500">*</span></label>
                    <input type="text" name="name" placeholder="Name (English)"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $userDetails->name ?? old('name') }}" readonly>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Name (Bangla)<span class="text-red-500">*</span></label>
                    <input type="text" name="name_bangla" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->name_bangla ?? old('name_bangla') }}">
                    @error('name_bangla')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Father's Name<span class="text-red-500">*</span></label>
                    <input type="text" name="fname" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->fname ?? old('fname') }}">
                    @error('fname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Academic Info -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Faculty<span class="text-red-500">*</span></label>
                    <input type="text" name="faculty" placeholder="Faculty"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $userDetails->faculty ?? old('faculty') }}" readonly>
                    @error('faculty')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Department<span class="text-red-500">*</span></label>
                    <input type="text" name="department" placeholder="Department"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $userDetails->department ?? old('department') }}" readonly>
                    @error('department')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Session<span class="text-red-500">*</span></label>
                    <input type="text" name="session" placeholder="Session"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->session ?? old('session') }}">
                    @error('session')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Hall Name<span class="text-red-500">*</span></label>
                    <input type="text" name="hall_name" placeholder="Hall Name"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $userDetails->hall_name ?? old('hall_name') }}" readonly>
                    @error('hall_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contact -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Email<span class="text-red-500">*</span></label>
                    <input type="email" name="email" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->email ?? old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Mobile<span class="text-red-500">*</span></label>
                    <input type="text" name="mobile" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->mobile ?? old('mobile') }}">
                    @error('mobile')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Emergency -->
            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold">Emergency Contact Name<span class="text-red-500">*</span></label>
                    <input type="text" name="emergency_contact_name" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->emergency_contact_name ?? old('emergency_contact_name') }}">
                    @error('emergency_contact_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Emergency Contact No<span class="text-red-500">*</span></label>
                    <input type="text" name="emergency_contact_no" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->emergency_contact_no ?? old('emergency_contact_no') }}">
                    @error('emergency_contact_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Relation<span class="text-red-500">*</span></label>
                    <input type="text" name="emergency_contact_relation" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->emergency_contact_relation ?? old('emergency_contact_relation') }}">
                    @error('emergency_contact_relation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Permanent Address<span class="text-red-500">*</span></label>
                    <textarea name="permanent_address" placeholder="E.g. Village, Post Office, Upazila/Thana, District"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $userDetails->permanent_address ?? old('permanent_address') }}</textarea>
                    @error('permanent_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Present Address<span class="text-red-500">*</span></label>
                    <textarea name="present_address" placeholder="E.g. Village, Post Office, Upazila/Thana, District"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ $userDetails->present_address ?? old('present_address') }}</textarea>
                    @error('present_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Any Relatives residing in Rajshahi?<span
                            class="text-red-500">*</span></label>
                    <select name="relatives_in_rajshahi"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select</option>
                        <option value="yes"
                            {{ ($userDetails->relatives_in_rajshahi ?? old('relatives_in_rajshahi')) == 'yes' ? 'selected' : '' }}>
                            Yes</option>
                        <option value="no"
                            {{ ($userDetails->relatives_in_rajshahi ?? old('relatives_in_rajshahi')) == 'no' ? 'selected' : '' }}>
                            No</option>
                    </select>
                    @error('relatives_in_rajshahi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold">Home Located in Rajshahi City Corporation?<span
                            class="text-red-500">*</span></label>
                    <select name="is_home_in_rajshahi"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select</option>
                        <option value="yes"
                            {{ ($userDetails->is_home_in_rajshahi ?? old('is_home_in_rajshahi')) == 'yes' ? 'selected' : '' }}>
                            Yes</option>
                        <option value="no"
                            {{ ($userDetails->is_home_in_rajshahi ?? old('is_home_in_rajshahi')) == 'no' ? 'selected' : '' }}>
                            No</option>
                    </select>
                    @error('is_home_in_rajshahi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Current Year -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Current Year<span class="text-red-500">*</span></label>
                    <select id="current_year" name="current_year"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select Year</option>
                        <option value="2"
                            {{ ($userDetails->current_year ?? old('current_year')) == '2' ? 'selected' : '' }}>2nd Year
                        </option>
                        <option value="3"
                            {{ ($userDetails->current_year ?? old('current_year')) == '3' ? 'selected' : '' }}>3rd Year
                        </option>
                        <option value="4"
                            {{ ($userDetails->current_year ?? old('current_year')) == '4' ? 'selected' : '' }}>4th Year
                        </option>
                        <option value="5"
                            {{ ($userDetails->current_year ?? old('current_year')) == '5' ? 'selected' : '' }}>Master's
                        </option>
                    </select>
                    @error('current_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="font-semibold">Current Semester</label>
                    <select id="current_semester" name="current_semester"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select Semester</option>
                        <option value="1"
                            {{ ($userDetails->current_semester ?? old('current_semester')) == '1' ? 'selected' : '' }}>1st
                            Semester</option>
                        <option value="2"
                            {{ ($userDetails->current_semester ?? old('current_semester')) == '2' ? 'selected' : '' }}>2nd
                            Semester</option>
                    </select>
                    @error('current_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- GPA Section -->
            <div id="gpa_fields"
                class="grid md:grid-cols-2 gap-4 {{ $userDetails->current_year ?? '' ? '' : 'hidden' }}">
                <div class="gpa gpa-1 {{ ($userDetails->current_year ?? 0) > 1 ? '' : 'hidden' }}">
                    <label class="font-semibold">1st Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_1st_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->gpa_1st_year ?? old('gpa_1st_year') }}">
                    @error('gpa_1st_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="gpa gpa-2 {{ ($userDetails->current_year ?? 0) > 2 ? '' : 'hidden' }}">
                    <label class="font-semibold">2nd Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_2nd_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->gpa_2nd_year ?? old('gpa_2nd_year') }}">
                    @error('gpa_2nd_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="gpa gpa-3 {{ ($userDetails->current_year ?? 0) > 3 ? '' : 'hidden' }}">
                    <label class="font-semibold">3rd Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_3rd_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->gpa_3rd_year ?? old('gpa_3rd_year') }}">
                    @error('gpa_3rd_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="gpa gpa-4 {{ ($userDetails->current_year ?? 0) > 4 ? '' : 'hidden' }}">
                    <label class="font-semibold">4th Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_4th_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->gpa_4th_year ?? old('gpa_4th_year') }}">
                    @error('gpa_4th_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-gray-400 my-6">
            <h4 class="text-lg font-semibold mb-1">Extra-Curricular Activities</h4>

            <!-- Certificates -->
            <div class="grid md:grid-cols-2 gap-4">
                @php
                    $certificates = [
                        [
                            'field' => 'international_certificate',
                            'path_field' => 'international_certificate_path',
                            'name' => 'International Certificate',
                        ],
                        [
                            'field' => 'national_certificate',
                            'path_field' => 'national_certificate_path',
                            'name' => 'National Certificate',
                        ],
                        [
                            'field' => 'university_certificate',
                            'path_field' => 'university_certificate_path',
                            'name' => 'University Certificate',
                        ],
                        [
                            'field' => 'journalism_certificate',
                            'path_field' => 'journalism_certificate_path',
                            'name' => 'Journalism Certificate',
                        ],
                        [
                            'field' => 'bncc_certificate',
                            'path_field' => 'bncc_certificate_path',
                            'name' => 'BNCC Certificate',
                        ],
                        [
                            'field' => 'roverscout_certificate',
                            'path_field' => 'roverscout_certificate_path',
                            'name' => 'Rover/Scout Certificate',
                        ],
                    ];
                @endphp

                @foreach ($certificates as $cert)
                    <div class="border rounded-lg bg-gray-50">
                        <label class="font-semibold block mb-2">{{ $cert['name'] }}</label>

                        <!-- Certificate status dropdown -->
                        <select name="{{ $cert['field'] }}"
                            class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none mb-2">
                            <option value="">Select Status</option>
                            <option value="yes"
                                {{ ($userDetails->{$cert['field']} ?? old($cert['field'])) == 'yes' ? 'selected' : '' }}>
                                Yes</option>
                            <option value="no"
                                {{ ($userDetails->{$cert['field']} ?? old($cert['field'])) == 'no' ? 'selected' : '' }}>No
                            </option>
                        </select>

                        @error($cert['field'])
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Submit -->
            <div class="flex justify-center space-x-4">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold">
                    Update Application Form
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const yearSelect = document.getElementById('current_year');
        const gpaFields = document.getElementById('gpa_fields');

        // Function to show/hide GPA fields
        function updateGpaFields() {
            const year = parseInt(yearSelect.value);

            if (year) {
                // show container
                gpaFields.classList.remove('hidden');

                // hide all
                document.querySelectorAll('.gpa').forEach(el => el.classList.add('hidden'));

                // show only required GPAs
                for (let i = 1; i < year; i++) {
                    const gpaField = document.querySelector('.gpa-' + i);
                    if (gpaField) {
                        gpaField.classList.remove('hidden');
                    }
                }
            } else {
                gpaFields.classList.add('hidden');
            }
        }

        // Initialize on page load
        updateGpaFields();

        // Update when year selection changes
        yearSelect.addEventListener('change', updateGpaFields);
    </script>
@endsection
