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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('name_bangla');
            $table->string('fname');
            $table->string('faculty');
            $table->string('department');
            $table->string('session');
            $table->string('hall_name');
            $table->string('email')->unique();
            $table->string('emergency_contact_name');
            $table->string('emergency_contact_no');
            $table->string('emergency_contact_relation');
            $table->string('mobile');
            $table->string('permanent_address');
            $table->string('present_address');
            $table->string('relatives_in_rajshahi');
            $table->string('is_home_in_rajshahi');
            $table->string('current_year');
            $table->string('current_semester')->nullable();
            $table->string('gpa_1st_year')->nullable();
            $table->string('gpa_2nd_year')->nullable();
            $table->string('gpa_3rd_year')->nullable();
            $table->string('gpa_4th_year')->nullable();
            $table->string('international_certificate')->nullable();
            $table->string('international_certificate_path')->nullable();
            $table->string('national_certificate')->nullable();
            $table->string('national_certificate_path')->nullable();
            $table->string('university_certificate')->nullable();
            $table->string('university_certificate_path')->nullable();
            $table->string('journalism_certificate')->nullable();
            $table->string('journalism_certificate_path')->nullable();
            $table->string('bncc_certificate')->nullable();
            $table->string('bncc_certificate_path')->nullable();
            $table->string('roverscout_certificate')->nullable();
            $table->string('roverscout_certificate_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
