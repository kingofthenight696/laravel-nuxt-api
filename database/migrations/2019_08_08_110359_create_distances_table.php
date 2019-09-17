<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distances', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('city_from')->unsigned()->nullable();
            $table->bigInteger('city_to')->unsigned()->nullable();
            $table->integer('distance');

            $table->timestamps();

            $table->foreign('city_from')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('city_to')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distances');

        Schema::create('distances', function (Blueprint $table) {
            $table->dropForeign(['city_from', 'city_to']);
        });
    }
}
