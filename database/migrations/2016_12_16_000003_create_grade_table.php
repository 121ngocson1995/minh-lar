<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')               //INT(10)
                ->unsigned();
            $table->foreign('student_id')               //foreign key -> students.id
                ->references('id')
                ->on('students')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('semester')               //INT(10)
                ->unsigned();
            $table->foreign('semester')               //foreign key -> students.id
                ->references('semester')
                ->on('semesters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->float('math', 4, 2)                 //FLOAT(4,2)
                ->unsigned();
            $table->float('physics', 4, 2)              //FLOAT(4,2)
                ->unsigned();
            $table->float('chemistry', 4, 2)
                ->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['student_id', 'semester']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table->dropForeign(['student_id']);
        Schema::dropIfExists('grade');
    }
}
