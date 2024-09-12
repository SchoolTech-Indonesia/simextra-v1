<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndSchoolToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_role')->nullable();
            $table->unsignedBigInteger('id_school')->nullable();

           $table->foreign('id_role')->references('id')->on('roles');
           $table->foreign('id_school')->references('id')->on('schools');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropForeign(['id_school']);
            $table->dropColumn(['id_role', 'id_school']);
        });
    }
}
