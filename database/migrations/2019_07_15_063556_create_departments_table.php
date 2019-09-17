<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number');
            $table->json('address');
            $table->bigInteger('delivery_id')->unsigned();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->json('working_time');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('delivery_id')->references('id')->on('deliveries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');

        Schema::create('departments', function (Blueprint $table) {
            $table->dropForeign(['delivery_id', 'city_id']);
        });
    }
}
