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
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('ra')->unique()->nullable();
            $table->string('CPF', 14);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('status',['actived','inactived','pre_registred']);
            $table->enum('gender',['male','female']);
            $table->enum('profile',['admin','user','professor','student', 'externo']);
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
