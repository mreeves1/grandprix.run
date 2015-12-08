<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->integer('age')->nullable(); // not sure which we can depend on
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->integer('distance_value');
            $table->enum('distance_unit', ['feet', 'miles', 'meters', 'kilometers']);
            $table->date('race_date');
            $table->string('race_location', 255)->nullable();
            $table->string('race_notes', 255)->nullable();
            $table->boolean('active')->default(false);
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
        Schema::drop('records');
    }
}
