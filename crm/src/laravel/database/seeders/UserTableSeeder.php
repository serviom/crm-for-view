<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = User::where('email', 'admin@shvidkist.com.ua')->first();
        if(!$user){
			$user = User::create(
				[
					'name' => 'adminCRM',
					'email' => 'admin@shvidkist.com.ua',
					'phoneNumber' => '380961234567',
					'email_verified_at' => now(),
					'password' => '@dminCRM',
					'remember_token' => Str::random(10),
				]
			);
			$user->syncRoles(['SuperAdmin']);
		}

//        $user = User::create(
//            [
//                'name' => 'UserCRM',
//                'email' => 'user@shvidkist.com.ua',
//                'phoneNumber' => '380961111111',
//                'email_verified_at' => now(),
//                'password' => '@dminCRM',
//                'remember_token' => Str::random(10),
//            ]
//        );
//
//        $user->syncRoles(['Agent']);

//        User::factory()->count(50)->create();
//        $users = User::where('id', '<>' , 1)->get();
//        foreach ($users as $user) {
//            $user->syncRoles(['Agent']);
//        }
    }
}
