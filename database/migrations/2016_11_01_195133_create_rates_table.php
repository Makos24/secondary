<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('student_id');
			$table->integer('term');
			$table->integer('session');
			$table->integer('class');
			$table->integer('div');
			$table->integer('punctuality');
			$table->integer('attendance');
			$table->integer('assignments');
			$table->integer('perseverance');
			$table->integer('self_control');
			$table->integer('self_confidence');
			$table->integer('endurance');
			$table->integer('respect');
			$table->integer('relationship');
			$table->integer('leadership');
			$table->integer('honesty');
			$table->integer('neatness');
			$table->integer('responsibility');
			$table->integer('sports');
			$table->integer('skills');
			$table->integer('group_projects');
			$table->integer('merit');
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
        Schema::drop('rates');
    }
}
