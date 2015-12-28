<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('runner_id')->unsigned();
            $table->foreign('runner_id')->references('id')->on('runners');
            $table->integer('race_id')->unsigned();
            $table->foreign('race_id')->references('id')->on('races');
            $table->time('time');
            $table->text('notes');
            // TODO: After age grading is calculated store it here?
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
        Schema::drop('performances');
    }
}
