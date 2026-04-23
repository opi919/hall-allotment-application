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
            $filename = storage_path('app/public/' . $hall->name . '_data.xlsx');

            // Eager load 'bill' to prevent N+1 query performance issues
            $users = UserDetails::with('bill')->where('hall_name', $hall->name)->get();
            $headers = ['ID', 'Name', 'Department', 'Session', 'Hall', '1st Year GPA', '2nd Year GPA', '3rd Year GPA', '4th Year GPA', 'Highest GPA', 'Current Year', 'Current Semester', 'Score', 'Payment Status'];

            $writer = SimpleExcelWriter::create($filename)
                ->addHeader($headers);

            // 1. Filter out unpaid users first (saves processing power)
            $filteredUsers = $users->filter(function ($user) {
                return optional($user->bill)->payment_status == '1';
            });

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

                // Save the calculated score directly onto the user object dynamically
                $user->calculated_score = ($last_gpa / $user->last_highest_gpa) * 47 + $extra_score;

                return $user;
            });

            // 3. Sort the mapped collection
            // Note: I set score to 'desc' (highest score first). Change to 'asc' if needed.
            $sortedUsers = $processedUsers->sortBy([
                ['current_year', 'asc'],
                ['session', 'asc'],
                ['calculated_score', 'desc'],
            ]);

            // 4. Write the sorted data to the Excel file
            foreach ($sortedUsers as $user) {
                $writer->addRow([
                    $user->username,
                    $user->name,
                    $user->department,
                    $user->session,
                    $user->hall_name,
                    $user->gpa_1_year,
                    $user->gpa_2_year,
                    $user->gpa_3_year,
                    $user->gpa_4_year,
                    $user->last_highest_gpa,
                    $user->current_year,
                    $user->current_semester ?? '',
                    $user->calculated_score, // Using the property we created in step 2
                    $user->bill->payment_status,
                ]);
            }

            $writer->close();
            $this->info('Data exported for ' . $hall->name);
        }
    }
}
