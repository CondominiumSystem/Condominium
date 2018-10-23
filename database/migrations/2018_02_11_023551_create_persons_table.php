<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
        });


        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string('document_number',13);
            $table->string('phone',10);
            $table->string('cell_phone',10);
            $table->string('address',80)->nullable();
            $table->boolean('life_here')->default(0);
            $table->date('start_date')->nullable();
            $table->integer('user_id');
            $table->integer('person_type_id')->unsigned();
            $table->foreign('person_type_id')->references('id')->on('person_types');
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
        Schema::dropIfExists('persons');
        Schema::dropIfExists('person_types');
    }
}
