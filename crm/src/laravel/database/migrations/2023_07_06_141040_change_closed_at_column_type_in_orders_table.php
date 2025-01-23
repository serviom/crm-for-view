<?php

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeClosedAtColumnTypeInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = Order::all();

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('closed_at');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('closed_at')->nullable();
        });

        foreach($data as $v) {
            if(! isset($v->closed_at)) continue;

            $order = Order::find($v->id);
            $order->update(['closed_at'=>Carbon::parse($v->closed_at)->format('Y-m-d H:i:s')]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
