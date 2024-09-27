<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration
{
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            $table->timestamps();
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('classrooms');
    }
}
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateClassroomsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     // public function up(): void
//     // {
//     //     Schema::create('classrooms', function (Blueprint $table) {
//     //         $table->id();
//     //         $table->unsignedBigInteger('major_id');
//     //         $table->string('code')->unique();
//     //         $table->string('name')->unique();
//     //         $table->timestamps();
//     //         $table->foreign('major_id')->references('id')->on('majors');
//     //     });
//     // }

//     // /**
//     //  * Reverse the migrations.
//     //  */
//     // public function down(): void
//     // {
//     //     Schema::dropIfExists('classrooms');
//     // }
//     public function up(): void
//     {
//         Schema::create('classrooms', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('major_id') // This creates a BIGINT UNSIGNED 'major_id' column
//                   ->constrained('majors')
//                   ->onDelete('cascade'); // Optional: Define onDelete behavior

//             $table->string('code')->unique();
//             $table->string('name')->unique();
           
           
//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('classrooms');
//     }
// };
