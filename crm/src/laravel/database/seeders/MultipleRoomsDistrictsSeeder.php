<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MultipleRoomsDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasColumn('orders', 'rooms')) {
            $orders = Order::all();

            if (! empty($orders)) {
                foreach ($orders as $order) {
                    if(! empty($order->rooms)){
                        db::table('order_rooms')->insert([
                            'order_id' => $order->id,
                            'rooms' => $order->rooms,
                        ]);
                    }
                }
            }

            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('rooms');
            });
        }

        if (Schema::hasColumn('orders', 'district_id')) {
            $orders = Order::all();

            if (! empty($orders)) {
                foreach ($orders as $order) {
                    if(! empty($order->district_id)) {
                        db::table('district_order')->insert([
                            'order_id' => $order->id,
                            'district_id' => $order->district_id,
                        ]);
                    }
                }
            }

            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('district_id');
            });
        }
    }
}
