<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientPhone;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Client::factory()->count(50)->create()->each(function ($client) {
//            $phones = ClientPhone::factory()->count(3)->make();
//            $client->phoneNumbers()->saveMany($phones);
//        });

        if (Schema::hasColumn('clients', 'cooperation')) {
            $order = new Order;
            $clients = db::table('clients')->select(['id','cooperation'])->get();

            foreach ($clients as $client) {
                $clientOrders = $order->where('client_id', $client->id)->get();

                foreach ($clientOrders as $v) {
                    $v->stage_id = $client->cooperation;
                    $v->save();
                }
            }

            Schema::table('clients', function($table) {
                $table->dropColumn('cooperation');
            });
        }
    }
}
