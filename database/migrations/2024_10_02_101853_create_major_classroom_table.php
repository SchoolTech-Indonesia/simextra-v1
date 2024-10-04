<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorClassroomTable extends Migration
{
    public function up()
    {
        Schema::create('major_classroom', function (Blueprint $table) {
            $table->id();
            $table->foreignId('major_id')->references('id')->on('majors')->onDelete('cascade');
            $table->foreignId('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('major_classroom');
        
    }
}
