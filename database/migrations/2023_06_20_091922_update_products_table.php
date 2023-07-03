<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            
            $table->float('product_price')->change();
            $table->float('product_discount')->change();
            $table->integer('product_weight')->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function ($table) {

            $table->dropColumn(column: "product_price");
            $table->dropColumn(column: "product_discount");
            $table->dropColumn(column: "product_weight");

        });
    }
};
