<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeniorAgentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senior_agent_users', function (Blueprint $table) {
            $table->foreignId('senior_agent_id')->nullable();
            $table->foreign('senior_agent_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('senior_agent_users');
    }
}
