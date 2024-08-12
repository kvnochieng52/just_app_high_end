<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertySubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_sub_types', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('property_type_id')->nullable();
            $table->string('property_sub_type_name')->nullable();
            $table->integer('is_active')->nullable();
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
        Schema::dropIfExists('property_sub_types');
    }
}
