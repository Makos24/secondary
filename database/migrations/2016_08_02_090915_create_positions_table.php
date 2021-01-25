<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('student_id');
            $table->integer('level');
            $table->string('class');
            $table->integer('term');
            $table->integer('session');
			$table->integer('total');
            $table->integer('average');
            $table->integer('position');
			$table->integer('overall_avg');
            $table->integer('overall_mark');
            $table->integer('overall_pos');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('positions');
    }
}