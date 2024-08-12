<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lease_types', function (Blueprint $table) {
            $table->id();
            $table->string('lease_type_name')->nullable();
            $table->text('lease_type_description')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('order')->nullable();
            $table->string('lease_type_color_code')->nullable();
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
        Schema::dropIfExists('lease_types');
    }
}
