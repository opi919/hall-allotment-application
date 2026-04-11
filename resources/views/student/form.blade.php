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
                    <label class="font-semibold">Relation<span class="text-red-500">*</span></label>
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

                <div>
                    <label class="font-semibold">Current Semester</label>
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
                    <input type="number" step="0.001" name="gpa_1st_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="hidden gpa gpa-2">
                    <label class="font-semibold">2nd Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_2nd_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="hidden gpa gpa-3">
                    <label class="font-semibold">3rd Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_3rd_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div class="hidden gpa gpa-4">
                    <label class="font-semibold">4th Year GPA/YGPA<span class="text-red-500">*</span></label>
                    <input type="number" step="0.001" name="gpa_4th_year" placeholder=""
                        class="w-full border border-gray-400 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
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
        const yearSelect = document.getElementById('current_year');
        const gpaFields = document.getElementById('gpa_fields');

        yearSelect.addEventListener('change', function() {
            const year = parseInt(this.value);

            // show container
            gpaFields.classList.remove('hidden');

            // hide all
            document.querySelectorAll('.gpa').forEach(el => el.classList.add('hidden'));

            // show only required GPAs
            for (let i = 1; i < year; i++) {
                document.querySelector('.gpa-' + i).classList.remove('hidden');
            }

            if (!year) {
                gpaFields.classList.add('hidden');
            }
        });
    </script>
@endsection
