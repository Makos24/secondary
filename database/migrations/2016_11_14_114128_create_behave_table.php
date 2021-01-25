<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBehaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('behave', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('student_id');
			$table->integer('term');
			$table->integer('session');
			$table->integer('class');
			$table->integer('div');
			$table->integer('appearance');
			$table->integer('behaviour');
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
        Schema::drop('behave');
    }
}
