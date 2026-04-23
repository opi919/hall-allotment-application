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

            $users = UserDetails::where('hall_name', $hall->name)->get();
            $headers = ['ID', 'Name', 'Department', 'Session', 'Hall', '1st Year GPA', '2nd Year GPA', '3rd Year GPA', '4th Year GPA', 'Highest GPA', 'Score', 'Payment Status'];

            $writer = SimpleExcelWriter::create($filename)
                ->addHeader($headers);

            foreach ($users as $user) {
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
                    if ($user->{$activity->certificateField()}) {
                        $extra_score += $activity->score();
                    }
                }
                $extra_score = min($extra_score, 3); // Cap the extra score at 3
                $score = ($last_gpa / $user->last_highest_gpa) * 47 + $extra_score;
                if ($user->bill->payment_status == '1') {
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
                        $score,
                        $user->bill->payment_status,
                    ]);
                }
            }

            $writer->close();
            $this->info('Data exported for ' . $hall->name);
        }
    }
}
