<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ClientPhonesSeeder::class);
        $this->call(LandPurposeTableSeeder::class);
        $this->call(RoomTypeTableSeeder::class);
        $this->call(RoomPurposeTableSeeder::class);
        $this->call(LandOwnershipTableSeeder::class);
        $this->call(StagesSeeder::class);
        $this->call(IncomeSourcesSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(MultipleRoomsDistrictsSeeder::class);
        $this->call(MultipleFloorsSeeder::class);
        $this->call(OrderStageSeeder::class);
        $this->call(RolesPermissionSeeder::class);
        $this->call(StagesUnsubscribePeriodSeeder::class);
    }
}
