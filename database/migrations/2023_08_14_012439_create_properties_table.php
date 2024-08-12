<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_title')->nullable();
            $table->text('slug')->nullable();
            $table->integer('bedrooms')->nullable();
            $table->bigInteger('town_id')->nullable();
            $table->bigInteger('region_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->integer('condition_id')->nullable();
            $table->integer('furnish_id')->nullable();
            $table->integer('parking_spaces')->nullable();
            $table->integer('secure_parking')->default(0);
            $table->integer('measurements')->nullable();
            $table->integer('units')->nullable();
            $table->text('address')->nullable();
            $table->integer('lease_type_id')->nullable();
            $table->text('property_description')->nullable();
            $table->bigInteger('amount')->nullable();
            $table->text('video_link')->nullable();
            $table->text('video_thumb')->nullable();
            $table->text('thumbnail')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();

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
        Schema::dropIfExists('properties');
    }
}
