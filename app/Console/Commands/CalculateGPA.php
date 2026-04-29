<?php

namespace App\Console\Commands;

use App\Models\UserDetails;
use Illuminate\Console\Command;

class CalculateGPA extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:gpa';

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
        $users = UserDetails::all();

        $this->output->progressBarStart(count($users));
        foreach ($users as $user) {
            if ($user->academic_system == 'semester') {
                $user->gpa_1_year = null;
                $user->gpa_2_year = null;
                $user->gpa_3_year = null;
                $user->gpa_4_year = null;

                $currentYear = $user->current_year;
                $currentSemester = $user->current_semester;
                $completedSemesters = min(($currentYear - 1) * 2 + ($currentSemester - 1), 8);

                for ($i = 1; $i <= $completedSemesters; $i++) {
                    if ($i % 2 == 0) {
                        $year = $i / 2;
                        $user->{'gpa_' . $year . '_year'} = round(($user->{"semester_{$i}_gpa"} + $user->{"semester_" . ($i - 1) . "_gpa"}) / 2, 3);
                    } elseif ($i == $completedSemesters && $currentSemester == 2) {
                        $year = ceil($i / 2);
                        $user->{'gpa_' . $year . '_year'} = round($user->{"semester_{$i}_gpa"}, 3);
                    }
                }
                $user->save();
            }
            $this->output->progressBarAdvance();
        }
        $this->output->progressBarFinish();
    }
}
