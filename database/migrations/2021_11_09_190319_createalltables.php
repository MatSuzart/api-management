<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createalltables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->string('password');
        });

        Schema::create('units', function (Blueprint $table){
            $table->id();
            $table->string('name');
            $table->integer('id_owner');
        });

        Schema::create('walls', function (Blueprint $table){
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->dateTime('datecreated');
        });

        Schema::create('walllikes', function (Blueprint $table){
            $table->id();
            $table->integer('id_wall');
            $table->integer('id_user');
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
        Schema::dropIfExists('units');
        Schema::dropIfExists('walls');
        Schema::dropIfExists('wallslikes');

    }
}
