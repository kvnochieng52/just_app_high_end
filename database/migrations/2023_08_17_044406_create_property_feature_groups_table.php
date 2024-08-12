<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyFeatureGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_feature_groups', function (Blueprint $table) {
            $table->id();
            $table->string('feature_group_name')->nullable();
            $table->text('group_icon')->nullable();
            $table->text('group_description')->nullable();
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
        Schema::dropIfExists('property_feature_groups');
    }
}
