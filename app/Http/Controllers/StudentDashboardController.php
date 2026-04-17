<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Department;
use App\Models\Hall;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class StudentDashboardController extends Controller
{
    //add middleware to check if user is authenticated
    public function __construct()
    {
        $this->middleware('allowApplication')->except(['index', 'downloadForm']);
    }

    public function index()
    {
        $userDetails = UserDetails::where('username', auth()->user()->username)->first();
        if (!$userDetails) {
            return redirect()->route('student.form');
        }

        $bill = Bill::where('username', auth()->user()->username)->first();
        if (!$bill) {
            return redirect()->route('student.form');
        }
        return view('student.dashboard', compact('userDetails', 'bill'));
    }

    public function showForm()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }
        $userDetails = UserDetails::where('username', $user->username)->first();
        if ($userDetails) {
            return redirect()->route('student.dashboard')->with('error', 'You have already submitted the form.For changes, go to edit information section.');
        }

        try {
            //dept_code = sixth and seventh digit of the username
            $dept_code = substr($user->username, 5, 2);
            $department = Department::where('code', $dept_code)->first();

            $data['username'] = $user->username;
            $data['name'] = $user->name;
            $data['department'] = $department->name;
            //session = first two digit of the username
            $session = substr($user->username, 0, 2);
            $data['session'] = '20' . $session - 1 . '-' . $session;
            $data['faculty'] = $department->faculty->name;
            //hall_name = third,fourth and fifth digit of the username
            $hall_code = substr($user->username, 2, 3);
            $hall_name = Hall::where('code', $hall_code)->first();
            $data['hall_name'] = $hall_name->name;
            $data['hall_code'] = $hall_code;
        } catch (\Exception $e) {
            Log::error('Error fetching department or hall information', ['error' => $e->getMessage(), 'username' => $user->name, 'department' => $user->department]);
            throw new \Exception('Error fetching department or hall information');
        }

        return view('student.form', $data);
    }

    public function submitForm(Request $request)
    {
        // Base validation rules
        $rules = [
            'username' => 'required|unique:user_details,username',
            'name' => 'required|string|max:255',
            'name_bangla' => 'required|regex:/^[\p{Bengali}\s]+$/u',
            'fname' => 'required|string|max:255',
            'faculty' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'session' => 'required|string|max:255',
            'hall_name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_details,email|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_no' => 'required|regex:/^01[2-9]\d{8}$/',
            'emergency_contact_relation' => 'required|string|max:255',
            'mobile' => 'required|regex:/^01[2-9]\d{8}$/|unique:user_details,mobile',
            'permanent_address' => 'required|string|max:1000',
            'present_address' => 'required|string|max:1000',
            'relatives_in_rajshahi' => 'required|in:yes,no',
            'is_home_in_rajshahi' => 'required|in:yes,no',
            'academic_system' => 'required|in:semester,yearly',
            'current_year' => 'required|in:2,3,4,5',
            'current_semester' => 'required_if:academic_system,semester|nullable|in:1,2',
            'last_highest_gpa' => 'required|numeric|between:1,4',
            // Certificate fields
            'international_certificate' => 'nullable|in:yes',
            'national_certificate' => 'nullable|in:yes',
            'university_certificate' => 'nullable|in:yes',
            'journalism_certificate' => 'nullable|in:yes',
            'bncc_certificate' => 'nullable|in:yes',
            'roverscout_certificate' => 'nullable|in:yes',
            'blood_donor' => 'nullable|in:yes',
        ];

        // Custom validation messages
        $messages = [
            'name_bangla.regex' => 'The name in Bangla must contain only Bengali characters and spaces.',
            'emergency_contact_no.regex' => 'The emergency contact number must be a valid Bangladeshi mobile number (01XXXXXXXXX).',
            'mobile.regex' => 'The mobile number must be a valid Bangladeshi mobile number (01XXXXXXXXX).',
            'mobile.unique' => 'This mobile number is already registered.',
            'email.unique' => 'This email address is already registered.',
            'username.unique' => 'This username is already registered.',
            'academic_system.required' => 'Please select your academic system.',
            'current_semester.required_if' => 'Current semester is required for semester system.',
            'last_highest_gpa.required' => 'Last highest GPA is required.',
            'last_highest_gpa.between' => 'The GPA must be between 1 and 4.',
        ];

        // Dynamic GPA validation based on academic system and current year/semester
        if ($request->academic_system === 'semester') {
            $currentYear = (int) $request->current_year;
            $currentSemester = (int) $request->current_semester;

            // Calculate total completed semesters
            $completedSemesters = min(($currentYear - 1) * 2 + ($currentSemester - 1), 8);

            // Add validation for each completed semester
            for ($i = 1; $i <= $completedSemesters; $i++) {
                $rules["semester_{$i}_gpa"] = 'required|numeric|between:1,4';
                $messages["semester_{$i}_gpa.required"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' semester is required.';
                $messages["semester_{$i}_gpa.between"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' semester must be between 1 and 4.';
            }
        } else if ($request->academic_system === 'yearly') {
            $currentYear = (int) $request->current_year;

            // Add validation for each completed year
            for ($i = 1; $i < $currentYear; $i++) {
                $rules["gpa_{$i}_year"] = 'required|numeric|between:1,4';
                $messages["gpa_{$i}_year.required"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' year is required.';
                $messages["gpa_{$i}_year.between"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' year must be between 1 and 4.';
            }
        }

        // Validate the request
        $validated = $request->validate($rules, $messages);

        // Handle checkbox certificates (convert to yes/no)
        $certificateFields = [
            'international_certificate',
            'national_certificate',
            'university_certificate',
            'journalism_certificate',
            'bncc_certificate',
            'roverscout_certificate'
        ];

        foreach ($certificateFields as $field) {
            $validated[$field] = isset($validated[$field]) ? 'yes' : 'no';
        }

        if ($validated['academic_system'] === 'semester') {
            $completedSemesters = min(((int)$validated['current_year'] - 1) * 2 + ((int)$validated['current_semester'] - 1), 8);
            for ($i = 1; $i <= $completedSemesters; $i++) {
                //calculate gpa_*_year with average of two semesters
                if ($i % 2 == 0) {
                    $year = $i / 2;
                    $validated["gpa_{$year}_year"] = round(($validated["semester_{$i}_gpa"] + $validated["semester_" . ($i - 1) . "_gpa"]) / 2, 3);
                } else if ($i == $completedSemesters && $currentSemester == 2) {
                    $year = ceil($i / 2);
                    $validated["gpa_{$year}_year"] = round($validated["semester_{$i}_gpa"], 3);
                }
            }
        }

        DB::beginTransaction();
        try {
            // Create user details record
            UserDetails::create($validated);

            // Create bill record
            $bill = new Bill();
            $bill->bill_id = time() . rand(100, 999);
            $bill->username = $request->username;
            $bill->amount = 55;
            $bill->save();

            DB::commit();
            return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to submit application', [
                'username' => $request->username,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'Failed to submit application. Please try again.')->withInput();
        }
    }

    public function edit()
    {
        $user = auth()->user();
        $userDetails = UserDetails::where('username', $user->username)->first();

        if (!$userDetails) {
            return redirect()->route('student.form')->with('error', 'Please fill out the form first.');
        }

        return view('student.edit', compact('userDetails'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $userDetails = UserDetails::where('username', $user->username)->first();

        if (!$userDetails) {
            return redirect()->route('student.form')->with('error', 'No existing record found.');
        }

        // Base validation rules
        $rules = [
            'name_bangla' => 'required|regex:/^[\p{Bengali}\s]+$/u',
            'fname' => 'required',
            'session' => 'required',
            'email' => 'required|email|unique:user_details,email,' . $userDetails->id,
            'emergency_contact_name' => 'required',
            'emergency_contact_no' => 'required|regex:/^01[2-9]\d{8}$/',
            'emergency_contact_relation' => 'required',
            'mobile' => 'required|regex:/^01[2-9]\d{8}$/|unique:user_details,mobile,' . $userDetails->id,
            'permanent_address' => 'required',
            'present_address' => 'required',
            'relatives_in_rajshahi' => 'required|in:yes,no',
            'is_home_in_rajshahi' => 'required|in:yes,no',
            'academic_system' => 'required|in:semester,yearly',
            'current_year' => 'required|in:2,3,4,5',
            'current_semester' => 'required_if:academic_system,semester|nullable|in:1,2',
            'last_highest_gpa' => 'required|numeric|between:1,4',
            'international_certificate' => 'nullable|in:yes',
            'national_certificate' => 'nullable|in:yes',
            'university_certificate' => 'nullable|in:yes',
            'journalism_certificate' => 'nullable|in:yes',
            'bncc_certificate' => 'nullable|in:yes',
            'roverscout_certificate' => 'nullable|in:yes',
            'blood_donor' => 'nullable|in:yes',
        ];

        // Custom validation messages
        $messages = [
            'name_bangla.regex' => 'The name in Bangla must contain only Bengali characters and spaces.',
            'emergency_contact_no.regex' => 'The emergency contact number must be a valid Bangladeshi mobile number (01XXXXXXXXX).',
            'mobile.regex' => 'The mobile number must be a valid Bangladeshi mobile number (01XXXXXXXXX).',
            'mobile.unique' => 'This mobile number is already registered by another user.',
            'email.unique' => 'This email address is already registered by another user.',
            'academic_system.required' => 'Please select your academic system.',
            'current_semester.required_if' => 'Current semester is required for semester system.',
            'last_highest_gpa.required' => 'Last highest GPA is required.',
            'last_highest_gpa.between' => 'The GPA must be between 1 and 4.',
        ];

        // Dynamic GPA validation based on academic system and current year/semester
        if ($request->academic_system === 'semester') {
            $currentYear = (int) $request->current_year;
            $currentSemester = (int) $request->current_semester;

            // Calculate total completed semesters
            $completedSemesters = min(($currentYear - 1) * 2 + ($currentSemester - 1), 8);

            // Add validation for each completed semester
            for ($i = 1; $i <= $completedSemesters; $i++) {
                $rules["semester_{$i}_gpa"] = 'required|numeric|between:1,4';
                $messages["semester_{$i}_gpa.required"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' semester is required.';
                $messages["semester_{$i}_gpa.between"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' semester must be between 1 and 4.';
            }
        } else if ($request->academic_system === 'yearly') {
            $currentYear = (int) $request->current_year;

            // Add validation for each completed year
            for ($i = 1; $i < $currentYear; $i++) {
                $rules["gpa_{$i}_year"] = 'required|numeric|between:1,4';
                $messages["gpa_{$i}_year.required"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' year is required.';
                $messages["gpa_{$i}_year.between"] = "The GPA for {$i}" .
                    ($i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th'))) . ' year must be between 1 and 4.';
            }
        }

        // Validate the request
        $validated = $request->validate($rules, $messages);

        // Handle semester GPA calculation for yearly system
        if ($validated['academic_system'] === 'semester') {
            $currentYear = (int) $validated['current_year'];
            $currentSemester = (int) $validated['current_semester'];
            $completedSemesters = min(($currentYear - 1) * 2 + ($currentSemester - 1), 8);

            for ($i = 1; $i <= $completedSemesters; $i++) {
                // Calculate gpa_*_year with average of two semesters
                if ($i % 2 == 0) {
                    $year = $i / 2;
                    if (isset($validated["semester_{$i}_gpa"]) && isset($validated["semester_" . ($i - 1) . "_gpa"])) {
                        $validated["gpa_{$year}_year"] = round(($validated["semester_{$i}_gpa"] + $validated["semester_" . ($i - 1) . "_gpa"]) / 2, 3);
                    }
                } else if ($i == $completedSemesters && $currentSemester == 2) {
                    $year = ceil($i / 2);
                    if (isset($validated["semester_{$i}_gpa"])) {
                        $validated["gpa_{$year}_year"] = round($validated["semester_{$i}_gpa"], 3);
                    }
                }
            }
        }

        DB::beginTransaction();
        try {
            // Build dynamic update data
            $updateData = [
                'name_bangla' => $validated['name_bangla'],
                'fname' => $validated['fname'],
                'session' => $validated['session'],
                'email' => $validated['email'],
                'emergency_contact_name' => $validated['emergency_contact_name'],
                'emergency_contact_no' => $validated['emergency_contact_no'],
                'emergency_contact_relation' => $validated['emergency_contact_relation'],
                'mobile' => $validated['mobile'],
                'permanent_address' => $validated['permanent_address'],
                'present_address' => $validated['present_address'],
                'relatives_in_rajshahi' => $validated['relatives_in_rajshahi'],
                'is_home_in_rajshahi' => $validated['is_home_in_rajshahi'],
                'academic_system' => $validated['academic_system'],
                'current_year' => $validated['current_year'],
                'current_semester' => $validated['current_semester'] ?? null,
                'last_highest_gpa' => $validated['last_highest_gpa'],
                'international_certificate' => $validated['international_certificate'] ?? null,
                'national_certificate' => $validated['national_certificate'] ?? null,
                'university_certificate' => $validated['university_certificate'] ?? null,
                'journalism_certificate' => $validated['journalism_certificate'] ?? null,
                'bncc_certificate' => $validated['bncc_certificate'] ?? null,
                'roverscout_certificate' => $validated['roverscout_certificate'] ?? null,
                'blood_donor' => $validated['blood_donor'] ?? null,
            ];

            // Add GPA fields based on academic system
            if ($validated['academic_system'] === 'yearly') {
                $currentYear = (int) $validated['current_year'];
                for ($i = 1; $i < $currentYear; $i++) {
                    if (isset($validated["gpa_{$i}_year"])) {
                        $updateData["gpa_{$i}_year"] = $validated["gpa_{$i}_year"];
                    }
                }
            } else if ($validated['academic_system'] === 'semester') {
                $currentYear = (int) $validated['current_year'];
                $currentSemester = (int) $validated['current_semester'];
                $completedSemesters = min(($currentYear - 1) * 2 + ($currentSemester - 1), 8);

                // Add semester GPAs
                for ($i = 1; $i <= $completedSemesters; $i++) {
                    if (isset($validated["semester_{$i}_gpa"])) {
                        $updateData["semester_{$i}_gpa"] = $validated["semester_{$i}_gpa"];
                    }
                }

                // Add calculated yearly GPAs
                for ($i = 1; $i < $currentYear; $i++) {
                    if (isset($validated["gpa_{$i}_year"])) {
                        $updateData["gpa_{$i}_year"] = $validated["gpa_{$i}_year"];
                    }
                }
            }

            // Update the record
            $userDetails->update($updateData);

            DB::commit();
            return redirect()->route('student.dashboard')->with('success', 'Form updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update form: ' . $e->getMessage())->withInput();
        }
    }

    public function downloadForm()
    {
        $user = auth()->user();
        $details = UserDetails::where('username', $user->username)->first();
        $bill = Bill::where('username', $user->username)->first();

        $html = view('pdf.application-form', compact('user', 'details', 'bill'))->render();

        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $fontConfig = (new FontVariables())->getDefaults();
        $fontData = $fontConfig['fontdata'];

        //check if storage/mpdf directory exists, if not create it
        if (!file_exists(storage_path('mpdf'))) {
            mkdir(storage_path('mpdf'), 0755, true);
        }

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'showWatermarkImage' => true,
            'margin_top' => 8,
            'margin_right' => 10,
            'margin_left' => 10,
            'margin_bottom' => 8,
            'tempDir' => storage_path('mpdf'),
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'),
            ]),

            'fontdata' => $fontData + [
                'kalpurush' => [
                    'R' => 'kalpurush.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ],
            ],
        ]);

        $mpdf->SetWatermarkImage(public_path('logo/logo.png'), 0.1, 'D');
        $mpdf->SetProtection(['print'], '', 'mk919@', 128);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('application-form.pdf', 'D'); // Download
    }
}
