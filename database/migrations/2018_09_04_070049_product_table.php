<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('id_product')->unsigned();
            // $table->integer('id_category');
            $table->integer('quantity');
            $table->integer('on_rent')->default(0);
            $table->text('name');
            $table->text('description');
            $table->double('price', 15, 2);
            $table->text('category');
            $table->string('type', 15);
            $table->integer('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            //
        });
    }
}
