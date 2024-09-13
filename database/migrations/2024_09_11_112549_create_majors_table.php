<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorsTable extends Migration
{
    public function up()
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Unique code for each major
            $table->string('name')->unique(); // Major name should also be unique
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('majors');
    }
}
    