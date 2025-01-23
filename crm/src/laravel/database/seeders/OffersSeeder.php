<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OffersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Schema::hasTable('variants')) {
            $variants = db::table('variants')->get();

            foreach ($variants->toArray() as $v) {
                db::table('offers')->insert((array)$v);
            }

            Schema::dropIfExists('variants');
        }
    }
}
