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
            $table->string('code')->unique();
            $table->string('name')->unique(); 
            $table->timestamps();
            $table->unsignedBigInteger('koordinator_id')->nullable();
            $table->foreign('koordinator_id')->references('id')->on('users')->onDelete('set null');

        });
        
    }

    public function down()
    {
        Schema::dropIfExists('majors');
    }
}
    