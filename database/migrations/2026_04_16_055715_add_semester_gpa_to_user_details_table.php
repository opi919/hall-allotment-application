<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('semester_1_gpa')->nullable()->after('gpa_4th_year');
            $table->string('semester_2_gpa')->nullable()->after('semester_1_gpa');
            $table->string('semester_3_gpa')->nullable()->after('semester_2_gpa');
            $table->string('semester_4_gpa')->nullable()->after('semester_3_gpa');
            $table->string('semester_5_gpa')->nullable()->after('semester_4_gpa');
            $table->string('semester_6_gpa')->nullable()->after('semester_5_gpa');
            $table->string('semester_7_gpa')->nullable()->after('semester_6_gpa');
            $table->string('semester_8_gpa')->nullable()->after('semester_7_gpa');

            //rename gpa_1st_year, gpa_2nd_year, gpa_3rd_year, gpa_4th_year to gpa_1_year, gpa_2_year, gpa_3_year, gpa_4_year
            $table->renameColumn('gpa_1st_year', 'gpa_1_year');
            $table->renameColumn('gpa_2nd_year', 'gpa_2_year');
            $table->renameColumn('gpa_3rd_year', 'gpa_3_year');
            $table->renameColumn('gpa_4th_year', 'gpa_4_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            //
        });
    }
};
