<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMajorsTable extends Migration
{
    // public function up()
    // {
    //     Schema::create('majors', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('code')->unique();
    //         $table->string('name')->unique(); 
    //         $table->timestamps();
    //         $table->unsignedBigInteger('koordinator_id')->nullable();
    //         $table->foreign('koordinator_id')->references('id')->on('users')->onDelete('set null');

    //     });
        
    // }

    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id(); // This creates a BIGINT UNSIGNED 'id' column
            $table->string('name');
            $table->string('code')->unique();
            $table->foreignId('koordinator_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
}


    