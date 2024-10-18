<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_user');  // Referencing user (assuming users table uses UUID)
            $table->uuid('id_extrakurikuler')->nullable();  // Extracurricular field
            $table->uuid('id_status_applicant');  // Foreign key to status_applicant
            $table->string('name');
            $table->string('applicant_code')->unique();
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
