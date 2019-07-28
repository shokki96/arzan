<?php

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
            $table->longText('images')->nullable();
            $table->string('title');
            $table->text('description');
            $table->decimal('price')->nullable();
            $table->unsignedInteger('locationP')->nullable();
            $table->unsignedInteger('locationC')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedInteger('categoryP')->nullable();
            $table->unsignedInteger('categoryC')->nullable();
            $table->unsignedInteger('view')->default(0);
            $table->foreign('locationP')->references('id')->on('locations');
            $table->foreign('locationC')->references('id')->on('locations');
            $table->foreign('categoryP')->references('id')->on('categories');
            $table->foreign('categoryC')->references('id')->on('categories');
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
