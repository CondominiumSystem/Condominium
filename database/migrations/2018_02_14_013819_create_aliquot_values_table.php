<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAliquotValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aliquot_values', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('value',8,2);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('property_type_id')->unsigned();
            $table->foreign('property_type_id')->references('id')->on('property_types');
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
        Schema::dropIfExists('aliquot_values');
    }
}
