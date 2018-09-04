<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function(Blueprint $table){
          $table->unsignedInteger('id_category');
          $table->foreign('id_category')->references('id_category')->on('category');
        });
        Schema::table('file', function(Blueprint $table){
          $table->unsignedInteger('id_product');
          $table->foreign('id_product')->references('id_product')->on('product');
        });
        Schema::table('rent', function(Blueprint $table){
          $table->unsignedInteger('id_invoice');
          $table->unsignedInteger('id_product');
          $table->foreign('id_invoice')->references('id_invoice')->on('invoice');
          $table->foreign('id_product')->references('id_product')->on('product');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
