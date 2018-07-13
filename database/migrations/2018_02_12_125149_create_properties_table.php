<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('property_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',25);
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lot_number');
            $table->string('note',80)->nullable();
            $table->string('address',80);
            $table->boolean('active')->default(true);
            $table->integer('property_type_id')->unsigned();
            $table->foreign('property_type_id')->references('id')->on('property_types');
            $table->timestamps();
        });

        Schema::create('person_property', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('person_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->boolean('owner')->default(0);
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->foreign('person_id')->references('id')->on('persons');
            $table->foreign('property_id')->references('id')->on('properties');

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
        Schema::dropIfExists('person_property');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('property_types');

    }
}
