<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddFieldLastCommentDateInOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'last_comment_date')) {
                $table->timestamp('last_comment_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            }
        });

        Artisan::call('update:last-comment-date');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('last_comment_date');
        });
    }
}
