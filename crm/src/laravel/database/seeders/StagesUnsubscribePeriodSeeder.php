<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StagesUnsubscribePeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        db::table('stages')
            ->whereNull('unsubscribe_period')
            ->orWhere('unsubscribe_period', '<', 1)
            ->update([
                'unsubscribe_period' => 3,
            ]);
    }
}
