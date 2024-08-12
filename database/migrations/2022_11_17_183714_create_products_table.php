<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('slug');
            $table->text('description')->nullable();
            $table->date('date_online');
            $table->date('date_offline');
            $table->decimal('price', 8, 2);
            $table->string('currency');
            $table->string('mobile');
            $table->string('email');
            $table->bigInteger('category_id');
            $table->text('image')->nullable();
            $table->integer('order')->default(1);
            $table->integer('visible')->default(1);
            $table->bigInteger('created_by');
            $table->bigInteger('updated_by');
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
        Schema::dropIfExists('products');
    }
}
