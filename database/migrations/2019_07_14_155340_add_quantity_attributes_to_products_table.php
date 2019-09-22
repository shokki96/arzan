<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddQuantityAttributesToProductsTable extends Migration
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
            $table->string('quantity_attribute')->nullable();
            $table->string('quantity_attribute_ru')->nullable();
            $table->string('quantity_attribute_en')->nullable();
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
            $table->dropColumn('quantity_attribute');
            $table->dropColumn('quantity_attribute_ru');
            $table->dropColumn('quantity_attribute_en');
        });
    }
}
