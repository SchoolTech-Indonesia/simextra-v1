<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleAndSchoolToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->nullable()->after('two_factor_confirmed_at');
            $table->unsignedBigInteger('school_id')->nullable()->after('role_id');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign'); // Pastikan nama foreign key sesuai
            $table->dropForeign('users_school_id_foreign'); // Pastikan nama foreign key sesuai
            $table->dropColumn(['role_id', 'school_id']);
        });
    }
}
