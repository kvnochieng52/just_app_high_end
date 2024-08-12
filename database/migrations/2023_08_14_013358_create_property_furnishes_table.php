<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyFurnishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up()
    {
        Schema::create('property_furnishes', function (Blueprint $table) {
            $table->id();
            $table->string('furnish_name')->nullable();
            $table->string('color_code')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('property_furnishes');
    }
}
