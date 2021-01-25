<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_settings', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('session');
			$table->integer('term');
			$table->integer('close_date');
			$table->integer('resume_date');
			$table->boolean('current');
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
        Schema::drop('term_settings');
    }
}
