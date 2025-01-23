<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\Statistics\StatisticsService;
use Faker\Generator as FakerGenerator;
use Carbon\Carbon;

class StatisticsSeeder extends Seeder
{
    public $dt;

    public function __construct()
    {
        $this->dt = Carbon::now();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(StatisticsService $statistics, FakerGenerator $faker)
    {
        $this->dt->subDays(30);
        for($days = 1; $days < 31; $days++) {
            $data['created_at'] = $this->dt->addDay()->format('Y-m-d H:i:s');

            for ($i = 1; $i < $faker->numberBetween(1, 20); $i++) {
                $data['tags'] = [
                    [
                        'entity' => 'users',
                        'id' => $faker->numberBetween(1, 250),
                    ]
                ];
                $data['data'] = [
                    'clients_count' => $faker->numberBetween(1, 10),
                    'orders_count' => $faker->numberBetween(2, 10),
                    'showing_offers_count' => $faker->numberBetween(5, 20),
                    'income_sources' => [],
                    'orders' => [],
                ];

                $counts = $data['data']['clients_count'];
                for ($j = 1; $j < $faker->numberBetween(2, 6); $j++) {
                    $count = $faker->numberBetween(1, $counts);
                    $data['data']['income_sources'][] = [
                        'source_id' => $faker->numberBetween(1, 9),
                        'count' => $count,
                    ];
                    $counts -= $count;
                    if ($counts < 1) break;
                }

                $showing_offers_count = $data['data']['showing_offers_count'];
                for ($j = 0; $j < $data['data']['orders_count']; $j++) {
                    $offers_count = $faker->numberBetween(1, $showing_offers_count);
                    $showing_offers = $faker->numberBetween(1, $offers_count);

                    $data['data']['orders'][] = [
                        'order_id' => $faker->numberBetween(1, 200),
                        'client_id' => $faker->numberBetween(1, 200),
                        'offers_count' => $offers_count,
                        'showing_offers_count' => $showing_offers,
                    ];
                    $showing_offers_count -= $showing_offers;
                    if ($showing_offers_count < 1) break;
                }
                $data['data']['orders_count'] = count($data['data']['orders']);

                $statistics->createStatistics($data);
            }
        }
    }
}
