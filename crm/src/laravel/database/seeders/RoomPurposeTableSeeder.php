<?php

namespace Database\Seeders;

use App\Models\RoomPurpose;
use Illuminate\Database\Seeder;

class RoomPurposeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "Нежитлове приміщення",
            "Інше",
            "Цех",
            "Готель",
            "Ресторан",
            "Салон краси",
            "Стоматологія",
            "Магазин",
            "Аптека",
            "СТО",
            "Офісне",
            "Обслуговування виробничих приміщень і виробничої бази",
            "Приміщення культурно-дозвіллєвого призначення",
            "Приміщення побутового обслуговування і торгівлі",
            "Приміщення громадського призначення",
            "Приміщення громадського харчування",
            "Складське приміщення",
            "Приміщення вільного призначення",
            "Для будівництва і обслуговування інших будівель громадської забудови",
        ];

        foreach ($data as $order => $title) {
            $item = RoomPurpose::where('title', $title)->first();
            if(!$item) {
                RoomPurpose::create([
                    'title' => $title,
                    'order' => $order,
                ]);
            }
        }

//        RoomPurpose::factory()->count(30)->create();
    }
}
