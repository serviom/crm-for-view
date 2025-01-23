<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_floors', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable();
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('floors')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_floors');
    }
}
