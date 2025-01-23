<?php

namespace Database\Seeders;

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "Окрема будівля",
            "Частина окремої будівлі",
            "Приміщення",
            "Торгова площа",
            "Офіс",
            "Комплекс приміщень",
            "Маф, кіоск, вагончик",
            "Бутик",
            "Гараж",
            "Бокс",
            "Житлове приміщення",
            "Підвальне приміщення",
            "Кабінет",
            "Площадка",
            "Зал для конференцій",
            "Паркомісце",
            "Інша споруда",
        ];

        foreach ($data as $order => $title) {
            $item = RoomType::where('title', $title)->first();
            if(!$item) {
                RoomType::create([
                    'title' => $title,
                    'order' => $order,
                ]);
            }
        }

//        RoomType::factory()->count(30)->create();
    }
}
