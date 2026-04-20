@extends('layouts.app')

@section('content')
    <div class="container mx-auto my-8">
        @if (
            $errors->any() &&
                ($errors->has('gpa_1_year') ||
                    $errors->has('gpa_2_year') ||
                    $errors->has('gpa_3_year') ||
                    $errors->has('gpa_4_year') ||
                    $errors->has('gpa_1_semester') ||
                    $errors->has('gpa_2_semester') ||
                    $errors->has('gpa_3_semester') ||
                    $errors->has('gpa_4_semester') ||
                    $errors->has('gpa_5_semester') ||
                    $errors->has('gpa_6_semester') ||
                    $errors->has('gpa_7_semester') ||
                    $errors->has('gpa_8_semester')))
            <div class="max-w-5xl mx-auto p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-4">
                <strong>GPA Errors:</strong>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->messages() as $field => $messages)
                        @if (str_starts_with($field, 'gpa_'))
                            @foreach ($messages as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="max-w-5xl mx-auto p-4 bg-green-100 border border-green-400 text-green-700 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="max-w-5xl mx-auto p-4 bg-red-100 border border-red-400 text-red-700 rounded mb-4">
                {{ session('error') }}
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
                    <label class="font-semibold">Admission Session<span class="text-red-500">*</span></label>
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

            <div class="grid md:grid-cols-1 gap-4">
                <div>
                    <label class="font-semibold">In Which Academic System Are You Studying?<span
                            class="text-red-500">*</span></label>
                    <select id="academic_system" name="academic_system"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Select System</option>
                        <option value="yearly"
                            {{ ($userDetails->academic_system ?? old('academic_system')) == 'yearly' ? 'selected' : '' }}>
                            Yearly System</option>
                        <option value="semester"
                            {{ ($userDetails->academic_system ?? old('academic_system')) == 'semester' ? 'selected' : '' }}>
                            Semester System</option>
                    </select>
                    <p class="text-red-500 text-sm mt-1 hidden" id="academic-system-error">Select academic system first
                    </p>
                    @error('academic_system')
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

                <div class="hidden">
                    <label class="font-semibold">Current Semester<span class="text-red-500">*</span></label>
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
            <div id="gpa_fields" class="grid md:grid-cols-2 gap-4 hidden">
                @foreach ([1, 2, 3, 4] as $year)
                    <div class="hidden gpa gpa-{{ $year }}">
                        <label
                            class="font-semibold">{{ $year }}{{ $year == 1 ? 'st' : ($year == 2 ? 'nd' : ($year == 3 ? 'rd' : 'th')) }}
                            Year GPA/YGPA<span class="text-red-500">*</span></label>
                        <input type="text" name="gpa_{{ $year }}_year" placeholder=""
                            class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            value="{{ $userDetails->{'gpa_' . $year . '_year'} ?? old('gpa_' . $year . '_year') }}">
                        @error('gpa_' . $year . '_year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div id="semester_gpa_fields" class="grid md:grid-cols-2 gap-4 hidden">
                @foreach ([1, 2, 3, 4, 5, 6, 7, 8] as $semester)
                    <div class="hidden semester-gpa semester-gpa-{{ $semester }}">
                        <label
                            class="font-semibold">{{ $semester }}{{ $semester == 1 ? 'st' : ($semester == 2 ? 'nd' : ($semester == 3 ? 'rd' : 'th')) }}
                            Semester GPA<span class="text-red-500">*</span></label>
                        <input type="text" name="semester_{{ $semester }}_gpa" placeholder=""
                            class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            value="{{ $userDetails->{'semester_' . $semester . '_gpa'} ?? old('semester_' . $semester . '_gpa') }}">
                        @error('semester_' . $semester . '_gpa')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div id="last_highest_gpa" class="grid md:grid-cols-2 gap-4 hidden">
                <div class="">
                    <label class="font-semibold last_gpa_label">Highest GPA/SGPA/YGPA/CGPA in the Applicant’s Latest Result
                        Sheet</label> <br>
                    <small class="text-red-500">ভাইভার সময় এই সিটের (সর্বশেষ রেজাল্টের) কপি নিয়ে আসতে হবে।</small>
                    <input type="text" name="last_highest_gpa" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ $userDetails->last_highest_gpa ?? old('last_highest_gpa') }}">
                    @error('last_highest_gpa')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-gray-400 my-6">
            <h4 class="text-lg font-semibold mb-1">Extra-Curricular Activities</h4>

            <!-- Certificates -->
            <div class="grid md:grid-cols-2 gap-4">
                @foreach (App\ExtraCurricular::cases() as $activity)
                    <div class="flex items-center">
                        <input type="checkbox" name="{{ $activity->certificateField() }}" value="yes"
                            id="{{ $activity->certificateField() }}"
                            class="w-4 h-4 border border-gray-400 rounded focus:ring-2 focus:ring-blue-500"
                            {{ old($activity->certificateField(), $userDetails->{$activity->certificateField()}) == 'yes' ? 'checked' : '' }}>
                        <label for="{{ $activity->certificateField() }}" class="font-semibold ml-2 cursor-pointer">
                            {{ $activity->displayName() }}
                        </label>
                        @error($activity->certificateField())
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
        const academicSystemSelect = document.getElementById('academic_system');
        const currentSemesterSelect = document.getElementById('current_semester');
        const currentYearSelect = document.getElementById('current_year');
        const lastHighestGpaLabel = document.querySelector('.last_gpa_label');
        const lastHighestGpa = document.getElementById('last_highest_gpa');

        const gpaFields = document.getElementById('gpa_fields');
        const semesterGpaFields = document.getElementById('semester_gpa_fields');

        function handleAcademicSystem() {
            if (academicSystemSelect.value === 'semester') {
                currentSemesterSelect.parentElement.classList.remove('hidden');
                lastHighestGpa.classList.remove('hidden');
            } else if (academicSystemSelect.value === 'yearly') {
                currentSemesterSelect.parentElement.classList.add('hidden');
                lastHighestGpa.classList.remove('hidden');
            } else {
                currentSemesterSelect.parentElement.classList.add('hidden');
                lastHighestGpa.classList.add('hidden');
            }
        }

        function handleYearChange() {
            const year = parseInt(currentYearSelect.value);
            const semester = parseInt(currentSemesterSelect.value);

            document.querySelectorAll('.gpa').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.semester-gpa').forEach(el => el.classList.add('hidden'));

            if (academicSystemSelect.value === 'semester') {
                semesterGpaFields.classList.remove('hidden');
                gpaFields.classList.add('hidden');

                for (let i = 1; i <= (year - 1) * 2 + (semester - 1); i++) {
                    const el = document.querySelector(`.semester-gpa-${i}`);
                    if (el) el.classList.remove('hidden');
                }

            } else if (academicSystemSelect.value === 'yearly') {
                gpaFields.classList.remove('hidden');
                semesterGpaFields.classList.add('hidden');

                for (let i = 1; i < year; i++) {
                    const el = document.querySelector(`.gpa-${i}`);
                    if (el) el.classList.remove('hidden');
                }
            }
        }

        // Event listeners
        academicSystemSelect.addEventListener('change', function() {
            handleAcademicSystem();

            currentSemesterSelect.value = '';
            currentYearSelect.value = '';
            gpaFields.classList.add('hidden');
            semesterGpaFields.classList.add('hidden');
        });

        currentYearSelect.addEventListener('change', handleYearChange);
        currentSemesterSelect.addEventListener('change', handleYearChange);

        // ✅ IMPORTANT: Run on page load (after validation)
        window.addEventListener('DOMContentLoaded', function() {
            handleAcademicSystem();
            handleYearChange();
        });
    </script>
@endsection
