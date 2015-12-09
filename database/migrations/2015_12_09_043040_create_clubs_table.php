<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 200);
            $table->string('city', 50);
            $table->string('state', 2); // US only for now
            $table->string('zip_code', 10);
            $table->string('contact_name', 200); // punting on contacts table
            $table->string('contact_website', 255);
            $table->string('contact_email', 255);
            $table->string('contact_phone', 25);
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
        Schema::drop('clubs');
    }
}
