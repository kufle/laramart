<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product');
            $table->bigInteger('code_product');
            $table->integer('id_category')->unsigned();
            $table->string('product_name',100);
            $table->string('merk',50);
            $table->bigInteger('harga_beli')->unsigned();
            $table->integer('diskon')->unsigned();
            $table->bigInteger('harga_jual')->unsigned();
            $table->integer('stock')->unsigned();
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
        Schema::dropIfExists('product');
    }
}
