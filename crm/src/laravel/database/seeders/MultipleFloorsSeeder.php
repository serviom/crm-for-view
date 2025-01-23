<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MultipleFloorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasColumn('orders', 'floor')) {
            $orders = Order::all();

            if (! empty($orders)) {
                foreach ($orders as $order) {
                    if(! empty($order->floor)){
                        db::table('order_floors')->insert([
                            'order_id' => $order->id,
                            'floors' => $order->floor,
                        ]);
                    }
                }
            }

            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('floor');
            });
        }
    }
}
