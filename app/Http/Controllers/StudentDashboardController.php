<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Hall;
use App\Models\UserDetails;
use Illuminate\Http\Request;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $userDetails = UserDetails::where('username', auth()->user()->username)->first();
        if (!$userDetails) {
            return redirect()->route('student.form');
        }

        return view('student.dashboard', $userDetails);
    }

    public function showForm()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

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
        $data['hall_name'] = $hall_name ? $hall_name->name : 'Unknown Hall';
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

        UserDetails::create($request->all());

        return redirect()->route('student.dashboard')->with('success', 'Form submitted successfully!');
    }
}
