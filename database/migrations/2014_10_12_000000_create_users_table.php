<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('telephone')->unique()->nullable();
            $table->string('provider_id')->nullable();
            $table->string('company_name')->nullable();
            $table->text('website')->nullable();
            $table->text('facebook')->nullable();
            $table->text('twitter')->nullable();
            $table->text('tiktok')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('profile')->nullable();
            $table->text('avatar')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
