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

        <form method="POST" action="{{ route('student.form.submit') }}"
            class="max-w-5xl mx-auto p-6 bg-white shadow-lg rounded-2xl space-y-6">
            @csrf

            <h5 class="text-2xl font-bold text-center mb-6">Hall Application Form</h5>
            <!-- Basic Info -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Username <span class="text-red-500">*</span></label>
                    <input type="text" name="username" placeholder="Username"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $username }}" readonly>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Name (English)<span class="text-red-500">*</span></label>
                    <input type="text" name="name" placeholder="Name (English)"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $name }}" readonly>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Name (Bangla)<span class="text-red-500">*</span></label>
                    <input type="text" name="name_bangla" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('name_bangla') }}">
                    @error('name_bangla')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Father's Name<span class="text-red-500">*</span></label>
                    <input type="text" name="fname" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('fname') }}">
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
                        value="{{ $faculty }}" readonly>
                    @error('faculty')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Department<span class="text-red-500">*</span></label>
                    <input type="text" name="department" placeholder="Department"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $department }}" readonly>
                    @error('department')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Session<span class="text-red-500">*</span></label>
                    <input type="text" name="session" placeholder="Session"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $session }}" readonly>
                    @error('session')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Hall Name<span class="text-red-500">*</span></label>
                    <input type="text" name="hall_name" placeholder="Hall Name"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-500"
                        value="{{ $hall_name }}" readonly>
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
                        value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Mobile<span class="text-red-500">*</span></label>
                    <input type="text" name="mobile" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('mobile') }}">
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
                        value="{{ old('emergency_contact_name') }}">
                    @error('emergency_contact_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Emergency Contact No<span class="text-red-500">*</span></label>
                    <input type="text" name="emergency_contact_no" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('emergency_contact_no') }}">
                    @error('emergency_contact_no')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Emergency Contact Relation<span class="text-red-500">*</span></label>
                    <input type="text" name="emergency_contact_relation" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('emergency_contact_relation') }}">
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
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('permanent_address') }}</textarea>
                    @error('permanent_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="font-semibold">Present Address<span class="text-red-500">*</span></label>
                    <textarea name="present_address" placeholder="E.g. Village, Post Office, Upazila/Thana, District"
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('present_address') }}</textarea>
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
                        <option value="yes" {{ old('relatives_in_rajshahi') == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('relatives_in_rajshahi') == 'no' ? 'selected' : '' }}>No</option>
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
                        <option value="yes" {{ old('is_home_in_rajshahi') == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('is_home_in_rajshahi') == 'no' ? 'selected' : '' }}>No</option>
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
                        <option value="yearly" {{ old('academic_system') == 'yearly' ? 'selected' : '' }}>Yearly System
                        </option>
                        <option value="semester" {{ old('academic_system') == 'semester' ? 'selected' : '' }}>Semester
                            System</option>
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
                        <option value="2" {{ old('current_year') == '2' ? 'selected' : '' }}>2nd Year</option>
                        <option value="3" {{ old('current_year') == '3' ? 'selected' : '' }}>3rd Year</option>
                        <option value="4" {{ old('current_year') == '4' ? 'selected' : '' }}>4th Year</option>
                        <option value="5" {{ old('current_year') == '5' ? 'selected' : '' }}>Master's</option>
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
                        <option value="1" {{ old('current_semester') == '1' ? 'selected' : '' }}>1st Semester
                        </option>
                        <option value="2" {{ old('current_semester') == '2' ? 'selected' : '' }}>2nd Semester
                        </option>
                    </select>
                    @error('current_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- GPA Section -->
            <div id="gpa_fields" class="grid md:grid-cols-2 gap-4 hidden">
                <div class="hidden gpa gpa-1">
                    <label class="font-semibold">1st Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_1_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_1_year') }}">
                    @error('gpa_1_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden gpa gpa-2">
                    <label class="font-semibold">2nd Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_2_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_2_year') }}">
                    @error('gpa_2_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden gpa gpa-3">
                    <label class="font-semibold">3rd Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_3_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_3_year') }}">
                    @error('gpa_3_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden gpa gpa-4">
                    <label class="font-semibold">4th Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_4_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_4_year') }}">
                    @error('gpa_4_year')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="semester_gpa_fields" class="grid md:grid-cols-2 gap-4 hidden">
                <div class="hidden semester-gpa semester-gpa-1">
                    <label class="font-semibold">1st Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_1_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_1_semester') }}">
                    @error('gpa_1_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-2">
                    <label class="font-semibold">2nd Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_2_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_2_semester') }}">
                    @error('gpa_2_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-3">
                    <label class="font-semibold">3rd Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_3_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_3_semester') }}">
                    @error('gpa_3_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-4">
                    <label class="font-semibold">4th Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_4_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_4_semester') }}">
                    @error('gpa_4_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-5">
                    <label class="font-semibold">5th Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_5_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_5_semester') }}">
                    @error('gpa_5_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-6">
                    <label class="font-semibold">6th Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_6_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_6_semester') }}">
                    @error('gpa_6_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-7">
                    <label class="font-semibold">7th Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_7_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_7_semester') }}">
                    @error('gpa_7_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="hidden semester-gpa semester-gpa-8">
                    <label class="font-semibold">8th Semester GPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_8_semester" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        value="{{ old('gpa_8_semester') }}">
                    @error('gpa_8_semester')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <hr class="border-gray-400 my-6">
            <h4 class="text-lg font-semibold mb-1">Extra-Curricular Activities</h4>
            <!-- Certificates -->
            <div class="grid md:grid-cols-2 gap-4">
                @foreach (App\ExtraCurricular::cases() as $activity)
                    <div>
                        <label class="font-semibold">{{ $activity->displayName() }}</label>
                        <select name="{{ $activity->certificateField() }}"
                            class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Select Status</option>
                            <option value="yes" {{ old($activity->certificateField()) == 'yes' ? 'selected' : '' }}>Yes
                            </option>
                            <option value="no" {{ old($activity->certificateField()) == 'no' ? 'selected' : '' }}>No
                            </option>
                        </select>
                        @error($activity->certificateField())
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
            </div>

            <!-- Submit -->
            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl">
                    Submit Application
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

        const gpaFields = document.getElementById('gpa_fields');
        const semesterGpaFields = document.getElementById('semester_gpa_fields');

        function handleAcademicSystem() {
            if (academicSystemSelect.value === 'semester') {
                currentSemesterSelect.parentElement.classList.remove('hidden');
            } else {
                currentSemesterSelect.parentElement.classList.add('hidden');
            }
        }

        function handleYearChange() {
            const year = parseInt(currentYearSelect.value);

            document.querySelectorAll('.gpa').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.semester-gpa').forEach(el => el.classList.add('hidden'));

            if (academicSystemSelect.value === 'semester') {
                semesterGpaFields.classList.remove('hidden');

                for (let i = 1; i <= (year - 1) * 2; i++) {
                    const el = document.querySelector(`.semester-gpa-${i}`);
                    if (el) el.classList.remove('hidden');
                }

            } else if (academicSystemSelect.value === 'yearly') {
                gpaFields.classList.remove('hidden');

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

        // ✅ IMPORTANT: Run on page load (after validation)
        window.addEventListener('DOMContentLoaded', function() {
            handleAcademicSystem();
            handleYearChange();
        });
    </script>
@endsection
