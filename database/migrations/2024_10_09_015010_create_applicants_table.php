<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();  // Auto-incrementing integer for primary key
  // Referencing users table with integer key
            $table->uuid('id_extrakurikuler')->nullable();  // Extracurricular still uses UUID
            $table->foreignId('id_status_applicant')->constrained('status_applicants');  // Foreign key to status_applicant using integer
            $table->string('name');
            $table->string('applicant_code')->unique();  // Unique applicant code
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->onDelete('set null');  // Nullable classroom reference
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
 
