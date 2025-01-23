<?php

namespace Database\Seeders;

use App\Models\Handbook;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeSourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['Facebook', false],
            ['Instagram', false],
            ['OLX', false],
            ['DOM.RIA', false],
            ['Рекомендація', false],
            ['Банер', false],
            ['Розклейка', false],
            ['Візит в офіс', false],
            ['Інше', true],
        ];

        foreach ($data as $k => $v) {
            $item = db::table('income_sources')->where('title', $v[0])->first();
            if(!$item) {
                db::table('income_sources')->insert([
                    'title' => $v[0],
                    'with_comment' => $v[1],
                    'order' => $k,
                ]);
            }
        }
    }
}
