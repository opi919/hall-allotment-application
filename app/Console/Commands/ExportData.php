<?php

namespace App\Console\Commands;

use App\ExtraCurricular;
use App\Models\Hall;
use App\Models\UserDetails;
use Illuminate\Console\Command;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $halls = Hall::all();

        foreach ($halls as $hall) {
            $additionalHall = null;
            if ($hall->code == '111') {
                $additionalHall = Hall::where('code', '112')->first();
            } else if ($hall->code == '125') {
                $additionalHall = Hall::where('code', '126')->first();
            }
            $filename = storage_path('app/public/' . $hall->name . '_data.xlsx');

            // Eager load 'bill' to prevent N+1 query performance issues
            if ($additionalHall) {
                $users = UserDetails::with('bill')
                    ->whereIn('hall_name', [$hall->name, $additionalHall->name])
                    ->get();
            } else {
                $users = UserDetails::with('bill')->where('hall_name', $hall->name)->get();
            }
            $headers = ['ID', 'Name', 'Father\'s Name', 'Department', 'Hall', 'Mobile', 'Present Address', 'Permanent Address', '1st Year GPA', '2nd Year GPA', '3rd Year GPA', '4th Year GPA', 'Highest GPA', 'Session', 'Score', 'Current Year', 'Current Semester', 'Payment Status', 'Relatives residing in Rajshahi', 'Home Located in Rajshahi City Corporation', 'Emergency Contact Name', 'Emergency Contact Relation', 'Emergency Contact Mobile'];

            $writer = SimpleExcelWriter::create($filename)
                ->addHeader($headers);

            // 1. Filter out unpaid users first (saves processing power)
            $filteredUsers = $users->filter(function ($user) {
                return optional($user->bill)->payment_status == '1';
            });

            // 2. Map through the collection to calculate and temporarily store the score
            // 2. Map through the collection to calculate and temporarily store the score
            $processedUsers = $filteredUsers->map(function ($user) {
                $last_gpa = null;
                if ($user->gpa_4_year) {
                    $last_gpa = $user->gpa_4_year;
                } elseif ($user->gpa_3_year) {
                    $last_gpa = $user->gpa_3_year;
                } elseif ($user->gpa_2_year) {
                    $last_gpa = $user->gpa_2_year;
                } elseif ($user->gpa_1_year) {
                    $last_gpa = $user->gpa_1_year;
                }

                $extra_score = 0;
                foreach (ExtraCurricular::cases() as $activity) {
                    if ($user->{$activity->certificateField()} == 'yes') {
                        $extra_score += 1;
                    }
                }
                $extra_score = min($extra_score, 3); // Cap the extra score at 3

                // Save the calculated score
                $user->calculated_score = round(($last_gpa / $user->last_highest_gpa) * 47 + $extra_score);

                // NEW: Extract the first part of the session (e.g., '2022' from '2022-23')
                // We cast it to an integer (int) to ensure it sorts mathematically
                $user->session_start_year = (int) explode('-', $user->session)[0];

                return $user;
            });

            // 3. Sort the mapped collection
            // Note: I set score to 'desc' (highest score first). Change to 'asc' if needed.
            $sortedUsers = $processedUsers->sortBy([
                ['current_year', 'desc'],
                ['session_start_year', 'asc'],
                ['calculated_score', 'desc'],
            ]);

            // 4. Write the sorted data to the Excel file
            foreach ($sortedUsers as $user) {
                $writer->addRow([
                    $user->username,
                    $user->name,
                    $user->fname,
                    $user->department,
                    $user->hall_name,
                    $user->mobile,
                    $user->present_address,
                    $user->permanent_address,
                    $user->gpa_1_year ? number_format((float)$user->gpa_1_year, 3, '.', '') : null,
                    $user->gpa_2_year ? number_format((float)$user->gpa_2_year, 3, '.', '') : null,
                    $user->gpa_3_year ? number_format((float)$user->gpa_3_year, 3, '.', '') : null,
                    $user->gpa_4_year ? number_format((float)$user->gpa_4_year, 3, '.', '') : null,
                    $user->last_highest_gpa ? number_format((float)$user->last_highest_gpa, 3, '.', '') : null,
                    $user->session,
                    $user->calculated_score, // Using the property we created in step 2
                    $user->current_year == 5 ? 'Masters' : $user->current_year . ($user->current_year == 1 ? 'st' : ($user->current_year == 2 ? 'nd' : ($user->current_year == 3 ? 'rd' : 'th'))) . ' Year',
                    $user->current_semester ? $user->current_semester . ($user->current_semester == 1 ? 'st' : ($user->current_semester == 2 ? 'nd' : ($user->current_semester == 3 ? 'rd' : 'th'))) . ' Semester' : null,
                    $user->bill->payment_status == 1 ? 'Paid' : null,
                    $user->relatives_in_rajshahi == 'yes' ? 'Yes' : 'No',
                    $user->is_home_in_rajshahi == 'yes' ? 'Yes' : 'No',
                    $user->emergency_contact_name,
                    $user->emergency_contact_relation,
                    $user->emergency_contact_no,
                ]);
            }

            $writer->close();
            $this->info('Data exported for ' . $hall->name);
        }
    }
}
