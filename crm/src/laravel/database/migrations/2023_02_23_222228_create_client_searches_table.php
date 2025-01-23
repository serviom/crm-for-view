<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_searches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')
                ->references('id')->on('clients')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('adv_type')->nullable();
            $table->string('category')->nullable();
            $table->string('details')->nullable();
            $table->string('type')->nullable();
            $table->string('repair')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('show_more')->default(false);
            $table->string('closed_at')->nullable();
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
        Schema::dropIfExists('client_searches');
    }
}
