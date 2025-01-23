<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClientPhone;

class ClientPhonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->checkPhones(ClientPhone::all());
        $this->checkPhones(User::all());
    }

    private function checkPhones($phones)
    {
        foreach ($phones as &$v) {
            if(strlen($v->phoneNumber) > 10) {
                $v->phoneNumber = ltrim($v->phoneNumber, '38');
                $v->save();
            }
        }
    }
}
