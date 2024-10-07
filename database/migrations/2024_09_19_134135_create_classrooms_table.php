<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('major_id'); // Make sure this line is present
            $table->string('code')->unique();
            $table->string('name')->unique();
            $table->timestamps();
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade'); // Add foreign key constraint here
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};