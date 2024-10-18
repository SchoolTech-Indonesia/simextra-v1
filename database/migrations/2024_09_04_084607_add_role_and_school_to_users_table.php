<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndSchoolToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Change to use UUID instead of unsignedBigInteger
            $table->uuid('id_role')->nullable(); 
            $table->foreign('id_role')->references('id')->on('roles')->onDelete('set null');
            
            $table->uuid('id_school')->nullable(); 
            $table->foreign('id_school')->references('id')->on('schools')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropColumn(['id_role']);

            $table->dropForeign(['id_school']);
            $table->dropColumn(['id_school']);
        });
    }
}
