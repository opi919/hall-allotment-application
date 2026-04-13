<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Department;
use App\Models\Hall;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class StudentDashboardController extends Controller
{
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
            $department = strtolower(str_replace('&', 'and', $user->department));
            $department = Department::where('name', $department)->first();

            $data['username'] = $user->username;
            $data['name'] = $user->name;
            $data['department'] = $department->name;
            //session = first two digit of the username
            $session = substr($user->username, 0, 2);
            $data['session'] = $session - 1 . '-' . $session;
            $data['faculty'] = $department->faculty->name;
            //hall_name = third,fourth and fifth digit of the username
            $hall_code = substr($user->username, 2, 3);
            $hall_name = Hall::where('code', $hall_code)->first();
            $data['hall_name'] = $hall_name->name;
        } catch (\Exception $e) {
            Log::error('Error fetching department or hall information', ['error' => $e->getMessage(), 'username' => $user->name, 'department' => $user->department]);
            throw new \Exception('Error fetching department or hall information');
        }

        return view('student.form', $data);
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:user_details,username',
            'name' => 'required',
            'name_bangla' => 'required|regex:/^[\p{Bengali}\s]+$/u',
            'fname' => 'required',
            'faculty' => 'required',
            'department' => 'required',
            'session' => 'required',
            'hall_name' => 'required',
            'email' => 'required|email|unique:user_details,email',
            'emergency_contact_name' => 'required',
            'emergency_contact_no' => 'required|regex:/^\d{11}$/',
            'emergency_contact_relation' => 'required',
            'mobile' => 'required|regex:/^\d{11}$/',
            'permanent_address' => 'required',
            'present_address' => 'required',
            'relatives_in_rajshahi' => 'required',
            'is_home_in_rajshahi' => 'required',
            'current_year' => 'required',
            'current_semester' => 'nullable',
            'gpa_1st_year' => 'nullable|numeric|between:1,4',
            'gpa_2nd_year' => 'nullable|numeric|between:1,4',
            'gpa_3rd_year' => 'nullable|numeric|between:1,4',
            'gpa_4th_year' => 'nullable|numeric|between:1,4',
            'international_certificate' => 'nullable|in:yes,no',
            'national_certificate' => 'nullable|in:yes,no',
            'university_certificate' => 'nullable|in:yes,no',
            'journalism_certificate' => 'nullable|in:yes,no',
            'bncc_certificate' => 'nullable|in:yes,no',
            'roverscout_certificate' => 'nullable|in:yes,no',
        ]);

        DB::beginTransaction();
        try {
            UserDetails::create($request->all());

            $bill = new Bill();
            $bill->bill_id = time() . rand(100, 999);
            $bill->username = $request->username;
            $bill->amount = 55;
            $bill->save();

            DB::commit();
            return redirect()->route('student.dashboard')->with('success', 'Form submitted successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit form.');
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

        // Validation rules
        $request->validate([
            'name_bangla' => 'required|regex:/^[\p{Bengali}\s]+$/u',
            'fname' => 'required',
            'session' => 'required',
            'email' => 'required|email|unique:user_details,email,' . $userDetails->id,
            'emergency_contact_name' => 'required',
            'emergency_contact_no' => 'required|regex:/^\d{11}$/',
            'emergency_contact_relation' => 'required',
            'mobile' => 'required|regex:/^\d{11}$/',
            'permanent_address' => 'required',
            'present_address' => 'required',
            'relatives_in_rajshahi' => 'required|in:yes,no',
            'is_home_in_rajshahi' => 'required|in:yes,no',
            'current_year' => 'required|in:2,3,4,5',
            'current_semester' => 'nullable|in:1,2',
            'gpa_1st_year' => 'nullable|numeric|between:1,4',
            'gpa_2nd_year' => 'nullable|numeric|between:1,4',
            'gpa_3rd_year' => 'nullable|numeric|between:1,4',
            'gpa_4th_year' => 'nullable|numeric|between:1,4',
            'international_certificate' => 'nullable|in:yes,no',
            'national_certificate' => 'nullable|in:yes,no',
            'university_certificate' => 'nullable|in:yes,no',
            'journalism_certificate' => 'nullable|in:yes,no',
            'bncc_certificate' => 'nullable|in:yes,no',
            'roverscout_certificate' => 'nullable|in:yes,no',
        ]);

        DB::beginTransaction();
        try {
            // Update basic fields
            $updateData = $request->only([
                'name_bangla',
                'fname',
                'session',
                'email',
                'emergency_contact_name',
                'emergency_contact_no',
                'emergency_contact_relation',
                'mobile',
                'permanent_address',
                'present_address',
                'relatives_in_rajshahi',
                'is_home_in_rajshahi',
                'current_year',
                'current_semester',
                'gpa_1st_year',
                'gpa_2nd_year',
                'gpa_3rd_year',
                'gpa_4th_year',
                'international_certificate',
                'national_certificate',
                'university_certificate',
                'journalism_certificate',
                'bncc_certificate',
                'roverscout_certificate'
            ]);

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

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'showWatermarkImage' => true,
            'margin_top' => 8,
            'margin_right' => 10,
            'margin_left' => 10,
            'margin_bottom' => 8,
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

        $mpdf->SetWatermarkImage(public_path('logo.png'), 0.1, 'D');
        $mpdf->SetProtection(['print'], '', 'mk919@', 128);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('application-form.pdf', 'D'); // Download
    }
}
