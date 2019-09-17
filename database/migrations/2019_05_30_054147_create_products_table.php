<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->integer('displayed_price')->unsigned();
            $table->integer('price')->unsigned();
            $table->float('weight')->unsigned();
            $table->string('preview');
            $table->string('seo_title');
            $table->text('seo_description');
            $table->boolean('is_exist')->default(0);
            $table->integer('views')->default(0)->unsigned();
            $table->integer('likes')->default(0)->unsigned();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->bigInteger('owner_id')->unsigned()->nullable();
            $table->timestamps();


            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('set null');
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

        Schema::create('products', function (Blueprint $table) {
            $table->dropForeign(['category_id', 'owner_id']);
        });
    }
}
