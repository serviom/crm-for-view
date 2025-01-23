<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Order::all() as $order) {
            if(! isset($order->stage_id)) $order->update(['stage_id' => 1]);
        }
    }
}
