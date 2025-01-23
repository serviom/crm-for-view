<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => '🗄 Архів',
                'is_last' => true,
            ]
        ];

        foreach ($data as $k => $v) {
            $item = db::table('stages')->where('title', $v['title'])->first();

            if(! $item) {
                $order = $k;

                if($v['is_last']) {
                    db::table('stages')->where('is_last', true)->update(['is_last' => false]);
                    $order = db::table('stages')->max('order') + 10;
                }

                db::table('stages')->insert([
                    'title' => $v['title'],
                    'is_last' => $v['is_last'],
                    'order' => $order,
                ]);
            }
        }
    }
}
