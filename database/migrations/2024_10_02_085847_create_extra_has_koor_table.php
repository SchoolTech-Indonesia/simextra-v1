<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraHasKoorTable extends Migration
{
    public function up()
    {
        Schema::create('extra_has_koor', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('extra_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('extra_has_koor');
    }
}
