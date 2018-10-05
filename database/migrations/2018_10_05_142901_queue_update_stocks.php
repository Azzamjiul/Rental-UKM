<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QueueUpdateStocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('queue_update_stock', function (Blueprint $table) {
          $table->increments('id_queue');
          $table->unsignedInteger('id_product');
          $table->integer('quantity');
          $table->dateTime('rent_date');
          $table->integer('status')->default(0);
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
