<?php

namespace Database\Seeders;

use App\Models\LandOwnership;
use Illuminate\Database\Seeder;

class LandOwnershipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "приватизована",
            "комунальна",
            "спільного користування",
            "власність ОСББ",
            "сільської ради",
            "відсутнє",
            "в оренді",
            "міська",
            "не приватизована",
            "міської ради",
        ];

        foreach ($data as $order => $title) {
            $item = LandOwnership::where('title', $title)->first();
            if(!$item) {
                LandOwnership::create([
                    'title' => $title,
                    'order' => $order,
                ]);
            }
        }

//        LandOwnership::factory()->count(30)->create();
    }
}
