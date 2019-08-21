<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnToProductsTable extends Migration
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
            $table->text('title_en')->nullable();
            $table->text('description_en')->nullable();
            $table->text('title_ru')->nullable();
            $table->text('description_ru')->nullable();
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
            $table->dropColumn('title_en');
            $table->dropColumn('description_en');
            $table->dropColumn('title_ru');
            $table->dropColumn('description_ru');
        });
    }
}
