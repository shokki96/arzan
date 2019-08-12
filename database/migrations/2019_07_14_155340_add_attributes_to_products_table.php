<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttributesToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function __construct()
    {
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('colors')->nullable();
            $table->json('size')->nullable();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->boolean('stock')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('colors');
            $table->dropColumn('size');
            $table->dropColumn('quantity');
            $table->dropColumn('stock');
        });
    }
}
