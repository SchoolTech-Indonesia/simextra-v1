<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsPresensiTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('respons_presensi', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('id_presensi');
            $table->uuid('id_user');
            $table->uuid('id_status_presensi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respons_presensi');
    }
};
