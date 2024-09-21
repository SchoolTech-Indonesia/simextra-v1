<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeMajorIdNullableInClassroomsTable extends Migration
{
    public function up()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('major_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('major_id')->nullable(false)->change();
        });
    }
}
