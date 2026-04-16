<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Hall Allotment Application</title>
</head>

<body style="font-family: sans-serif; font-size: 12px; color: #333;">
    <div style="position: absolute; bottom: 20px; left: 40px; right: 40px;">
        <table class="w-full">
            <tr>
                <td class="text-xs text-right"><strong>Developed by:</strong> ICT Center, RU
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center;marin-bottom:10px !important;">
        <img src="{{ public_path('logo/logo.png') }}" alt="University Logo" style="display: block; width: 80px;">
    </div>
    <h2 style="text-align: center;margin-top:0px;margin-bottom:0px;font-weight: normal;">University of Rajshahi</h2>
    <h2 style="text-align: center; margin-bottom: 20px;margin-top:5px;">Hall Allotment Application</h2>

    <h3 style="margin-top:10px;">Personal Information</h3>

    <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>{{ $details->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Name (Bangla)</strong></td>
                        <td style="font-family: kalpurush">{{ $details->name_bangla ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Father's Name</strong></td>
                        <td>{{ $details->fname ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Student ID</strong></td>
                        <td>{{ $details->username ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>{{ $details->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Mobile</strong></td>
                        <td>{{ $details->mobile ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 40%"><strong>Relatives in Rajshahi?</strong></td>
                        <td style="text-transform: capitalize">{{ $details->relatives_in_rajshahi ?? '-' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%; vertical-align: top;">
                <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
                    <tr>
                        <td><strong>Faculty</strong></td>
                        <td>{{ $details->faculty ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Department</strong></td>
                        <td>{{ $details->department ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Hall</strong></td>
                        <td>{{ $details->hall_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Session</strong></td>
                        <td>{{ $details->session ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Current Year</strong></td>
                        <td>
                            @if ($details->current_year == 5)
                                Master's
                            @else
                                {{ $details->current_year == 1 ? '1st Year' : ($details->current_year == 2 ? '2nd Year' : ($details->current_year == 3 ? '3rd Year' : ($details->current_year == 4 ? '4th Year' : $details->current_year . 'th Year'))) }}
                            @endif
                        </td>
                    </tr>
                    @if ($details->current_semester)
                        <tr>
                            <td><strong>Current Semester</strong></td>
                            <td> {{ $details->current_semester == 1
                                ? '1st Semester'
                                : ($details->current_semester == 2
                                    ? '2nd Semester'
                                    : '3rd Semester') }}
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td style="width: 40%"><strong>Home Inside Rajshahi City?</strong></td>
                        <td style="text-transform: capitalize">{{ $details->is_home_in_rajshahi ?? '-' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><strong>Permanent Address</strong> : {{ $details->permanent_address ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2"><strong>Present Address</strong> : {{ $details->present_address ?? '-' }}</td>
        </tr>
    </table>

    <h3 style="margin-top:15px;">Emergency Contact Information</h3>

    <table width="100%" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td>
                <strong>Name</strong> : {{ $details->emergency_contact_name ?? '-' }}
            </td>
            <td>
                <strong>Relation</strong> : {{ $details->emergency_contact_relation ?? '-' }}
            </td>
            <td>
                <strong>Mobile</strong> : {{ $details->emergency_contact_no ?? '-' }}
            </td>
        </tr>
    </table>

    <h3 style="margin-top: 20px;">Bill Information</h3>

    <table width="100%" border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <tr>
            <td><strong>Bill ID</strong></td>
            <td style="width: 30%">{{ $bill->bill_id ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Amount</strong></td>
            <td>{{ $bill->amount ?? '-' }} BDT (@if ($bill->payment_status == 1)
                    <span style="color: green; font-weight: bold;">Paid</span>
                @else
                    <span style="color: red; font-weight: bold;">Unpaid</span>
                @endif)</td>
        </tr>

        @if ($bill->payment_status == 1)
            <tr>
                <td><strong>Payment Date</strong></td>
                <td>{{ \Carbon\Carbon::parse($bill->payment_date)->format('F j, Y') }}
                    ({{ $bill->payment_method ?? '-' }})</td>
            </tr>
        @endif
    </table>

    <h3 style="margin-top: 20px;">GPA Information</h3>

    <table width="100%" border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        @foreach ([1, 2, 3, 4] as $year)
            {{ $yearName = $year == 1 ? '1st' : ($year == 2 ? '2nd' : ($year == 3 ? '3rd' : '4th')) }}
            @if ($details->{'gpa_' . $year . '_year'})
                <tr>
                    <td>{{ $yearName }} Year GPA/YGPA</td>
                    <td style="width: 30%">{{ $details->{'gpa_' . $year . '_year'} ?? '-' }}</td>
                </tr>
            @endif
        @endforeach
        <tr>
            <td>Last Highest GPA/YGPA</td>
            <td style="width: 30%">{{ $details->last_highest_gpa ?? '-' }}</td>
        </tr>
    </table>

    <h3 style="margin-top: 20px;">Extra-Curricular Activities</h3>

    <table width="100%" border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        @foreach (App\ExtraCurricular::cases() as $c)
            @if ($details->{$c->certificateField()} == 'yes')
                <tr>
                    <td>{{ $c->displayName() }}</td>
                    <td style="text-transform: capitalize;width:30%;">{{ $details->{$c->certificateField()} ?? '-' }}
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

</body>

</html>
