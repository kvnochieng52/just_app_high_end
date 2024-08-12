<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('property_conditions', function (Blueprint $table) {
            $table->id();
            $table->string('condition_name')->nullable();
            $table->text('condition_description')->nullable();
            $table->string('condition_color_code')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('property_conditions');
    }
}
