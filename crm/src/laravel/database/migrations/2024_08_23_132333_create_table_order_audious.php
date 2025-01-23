<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderAudious extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_audious', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('filename');
            $table->boolean('archive')->default(0);
            $table->softDeletes();
            $table->timestamp('hear_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('order_audious');
    }
}
