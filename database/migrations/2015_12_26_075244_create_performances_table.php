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
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('race_id')->unsigned()->nullable();
            $table->foreign('race_id')->references('id')->on('races');
            $table->string('race_alt_name', 200);
            $table->integer('distance_id')->unsigned()->nullable();
            $table->foreign('distance_id')->references('id')->on('distances');
            $table->string('distance_alt_name', 200);
            $table->float('distance_alt_value'); // meters
            $table->float('time'); // seconds
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
