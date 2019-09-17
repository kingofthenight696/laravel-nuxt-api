<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('second_name')->nullable();
            $table->string('third_name')->nullable();
            $table->bigInteger('role_id')->unsigned();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->string('phone')->unique();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->integer('building_number')->nullable();
            $table->integer('apartment_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();


            $table->foreign('role_id')->references('id')->on('roles');

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

//        Schema::create('users', function (Blueprint $table) {
//            $table->dropForeign('users_role_id_foreign');
//        });
    }
}
