<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$role = Role::where('name', 'SuperAdmin')->first();
        if(!$role){
			Role::create([
				'name' => 'SuperAdmin',
				'description' => 'Супер адмін',
			]);
		}
		$role = Role::where('name', 'Admin')->first();
        if(!$role){
			Role::create([
				'name' => 'Admin',
				'description' => 'Адмін',
			]);
		}

		$role = Role::where('name', 'Photographer')->first();
        if(!$role){
			Role::create([
				'name' => 'Photographer',
				'description' => 'Фотограф',
			]);
		}

		$role = Role::where('name', 'Lawyer')->first();
        if(!$role){
			Role::create([
				'name' => 'Lawyer',
				'description' => 'Адвокат',
			]);
		}

		$role = Role::where('name', 'Agent')->first();
        if(!$role){
			Role::create([
				'name' => 'Agent',
				'description' => 'Агент',
			]);
		}

        $role = Role::where('name', 'SeniorAgent')->first();
        if(!$role){
            Role::create([
                'name' => 'SeniorAgent',
                'description' => 'Старший агент',
            ]);
        }

        //User
        $permission = Permission::where('name', 'users.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'users.viewAny',
            'group' => 'Користувачі',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'users.viewMyOnly')->first();
        if(!$permission) Permission::create([
            'name' => 'users.viewMyOnly',
            'group' => 'Користувачі',
            'title' => 'Тільки свої',
        ]);

        $permission = Permission::where('name', 'users.view')->first();
        if(!$permission) Permission::create([
            'name' => 'users.view',
            'group' => 'Користувачі',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'users.create')->first();
        if(!$permission) Permission::create([
            'name' => 'users.create',
            'group' => 'Користувачі',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'users.update')->first();
        if(!$permission) Permission::create([
            'name' => 'users.update',
            'group' => 'Користувачі',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'users.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'users.delete',
            'group' => 'Користувачі',
            'title' => 'Видалення',
        ]);

        //Roles
        $permission = Permission::where('name', 'roles.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'roles.viewAny',
            'group' => 'Ролі',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'roles.view')->first();
        if(!$permission) Permission::create([
            'name' => 'roles.view',
            'group' => 'Ролі',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'roles.create')->first();
        if(!$permission) Permission::create([
            'name' => 'roles.create',
            'group' => 'Ролі',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'roles.update')->first();
        if(!$permission) Permission::create([
            'name' => 'roles.update',
            'group' => 'Ролі',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'roles.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'roles.delete',
            'group' => 'Ролі',
            'title' => 'Видалення',
        ]);

        //Objects
        $permission = Permission::where('name', 'objects.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'objects.viewAny',
            'group' => 'Об\'єкти',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'objects.view')->first();
        if(!$permission) Permission::create([
            'name' => 'objects.view',
            'group' => 'Об\'єкти',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'objects.create')->first();
        if(!$permission) Permission::create([
            'name' => 'objects.create',
            'group' => 'Об\'єкти',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'objects.update')->first();
        if(!$permission) Permission::create([
            'name' => 'objects.update',
            'group' => 'Об\'єкти',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'objects.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'objects.delete',
            'group' => 'Об\'єкти',
            'title' => 'Видалення',
        ]);

        //Clients
        $permission = Permission::where('name', 'clients.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'clients.viewAny',
            'group' => 'Клієнти',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'clients.view')->first();
        if(!$permission) Permission::create([
            'name' => 'clients.view',
            'group' => 'Клієнти',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'clients.viewMyOnly')->first();
        if(!$permission) {
            Permission::create([
                'name' => 'clients.viewMyOnly',
                'group' => 'Клієнти',
                'title' => 'Тільки свої',
            ]);
        }

        $permission = Permission::where('name', 'clients.create')->first();
        if(!$permission) Permission::create([
            'name' => 'clients.create',
            'group' => 'Клієнти',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'clients.update')->first();
        if(!$permission) Permission::create([
            'name' => 'clients.update',
            'group' => 'Клієнти',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'clients.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'clients.delete',
            'group' => 'Клієнти',
            'title' => 'Видалення',
        ]);

        //Logs
        $permission = Permission::where('name', 'logs.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'logs.viewAny',
            'group' => 'Лог помилок',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'logs.view')->first();
        if(!$permission) Permission::create([
            'name' => 'logs.view',
            'group' => 'Лог помилок',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'logs.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'logs.delete',
            'group' => 'Лог помилок',
            'title' => 'Видалення',
        ]);

        //Action
        $permission = Permission::where('name', 'actions.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'actions.viewAny',
            'group' => 'Лог дій',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'actions.view')->first();
        if(!$permission) Permission::create([
            'name' => 'actions.view',
            'group' => 'Лог дій',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'actions.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'actions.delete',
            'group' => 'Лог дій',
            'title' => 'Видалення',
        ]);

        //LandPurpose
        $permission = Permission::where('name', 'land_purpose.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'land_purpose.viewAny',
            'group' => 'Цільове призначення на ділянки',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'land_purpose.view')->first();
        if(!$permission) Permission::create([
            'name' => 'land_purpose.view',
            'group' => 'Цільове призначення на ділянки',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'land_purpose.create')->first();
        if(!$permission) Permission::create([
            'name' => 'land_purpose.create',
            'group' => 'Цільове призначення на ділянки',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'land_purpose.update')->first();
        if(!$permission) Permission::create([
            'name' => 'land_purpose.update',
            'group' => 'Цільове призначення на ділянки',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'land_purpose.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'land_purpose.delete',
            'group' => 'Цільове призначення на ділянки',
            'title' => 'Видалення',
        ]);

        //RoomType
        $permission = Permission::where('name', 'room_type.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'room_type.viewAny',
            'group' => 'Тип приміщення',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'room_type.view')->first();
        if(!$permission) Permission::create([
            'name' => 'room_type.view',
            'group' => 'Тип приміщення',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'room_type.create')->first();
        if(!$permission) Permission::create([
            'name' => 'room_type.create',
            'group' => 'Тип приміщення',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'room_type.update')->first();
        if(!$permission) Permission::create([
            'name' => 'room_type.update',
            'group' => 'Тип приміщення',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'room_type.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'room_type.delete',
            'group' => 'Тип приміщення',
            'title' => 'Видалення',
        ]);

        //RoomPurpose
        $permission = Permission::where('name', 'room_purpose.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'room_purpose.viewAny',
            'group' => 'Цільове призначення на приміщення',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'room_purpose.view')->first();
        if(!$permission) Permission::create([
            'name' => 'room_purpose.view',
            'group' => 'Цільове призначення на приміщення',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'room_purpose.create')->first();
        if(!$permission) Permission::create([
            'name' => 'room_purpose.create',
            'group' => 'Цільове призначення на приміщення',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'room_purpose.update')->first();
        if(!$permission) Permission::create([
            'name' => 'room_purpose.update',
            'group' => 'Цільове призначення на приміщення',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'room_purpose.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'room_purpose.delete',
            'group' => 'Цільове призначення на приміщення',
            'title' => 'Видалення',
        ]);

        //LandOwnership
        $permission = Permission::where('name', 'land_ownership.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'land_ownership.viewAny',
            'group' => 'Право власності на землю',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'land_ownership.view')->first();
        if(!$permission) Permission::create([
            'name' => 'land_ownership.view',
            'group' => 'Право власності на землю',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'land_ownership.create')->first();
        if(!$permission) Permission::create([
            'name' => 'land_ownership.create',
            'group' => 'Право власності на землю',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'land_ownership.update')->first();
        if(!$permission) Permission::create([
            'name' => 'land_ownership.update',
            'group' => 'Право власності на землю',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'land_ownership.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'land_ownership.delete',
            'group' => 'Право власності на землю',
            'title' => 'Видалення',
        ]);

        //Stage of the agreement
        $permission = Permission::where('name', 'stage_agreement.view')->first();
        if(!$permission) Permission::create([
            'name' => 'stage_agreement.view',
            'group' => 'Етапи угоди',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'stage_agreement.create')->first();
        if(!$permission) Permission::create([
            'name' => 'stage_agreement.create',
            'group' => 'Етапи угоди',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'stage_agreement.update')->first();
        if(!$permission) Permission::create([
            'name' => 'stage_agreement.update',
            'group' => 'Етапи угоди',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'stage_agreement.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'stage_agreement.delete',
            'group' => 'Етапи угоди',
            'title' => 'Видалення',
        ]);

        //Income of the sources
        $permission = Permission::where('name', 'income_source.view')->first();
        if(!$permission) Permission::create([
            'name' => 'income_source.view',
            'group' => 'Джерела надходження',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'income_source.create')->first();
        if(!$permission) Permission::create([
            'name' => 'income_source.create',
            'group' => 'Джерела надходження',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'income_source.update')->first();
        if(!$permission) Permission::create([
            'name' => 'income_source.update',
            'group' => 'Джерела надходження',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'income_source.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'income_source.delete',
            'group' => 'Джерела надходження',
            'title' => 'Видалення',
        ]);

        //Райони
        $permission = Permission::where('name', 'districts.view')->first();
        if(!$permission) Permission::create([
            'name' => 'districts.view',
            'group' => 'Райони',
            'title' => 'Перегляд',
        ]);

        $permission = Permission::where('name', 'districts.create')->first();
        if(!$permission) Permission::create([
            'name' => 'districts.create',
            'group' => 'Райони',
            'title' => 'Створення',
        ]);

        $permission = Permission::where('name', 'districts.update')->first();
        if(!$permission) Permission::create([
            'name' => 'districts.update',
            'group' => 'Райони',
            'title' => 'Редагування',
        ]);

        $permission = Permission::where('name', 'districts.delete')->first();
        if(!$permission) Permission::create([
            'name' => 'districts.delete',
            'group' => 'Райони',
            'title' => 'Видалення',
        ]);


        //statistics
        $permission = Permission::where('name', 'statistics.viewAny')->first();
        if(!$permission) Permission::create([
            'name' => 'statistics.viewAny',
            'group' => 'Статистика',
            'title' => 'Перегляд всіх',
        ]);

        $permission = Permission::where('name', 'statistics.clients')->first();
        if(!$permission) Permission::create([
            'name' => 'statistics.clients',
            'group' => 'Статистика',
            'title' => 'Клієнти',
        ]);

        $permission = Permission::where('name', 'statistics.orders')->first();
        if(!$permission) Permission::create([
            'name' => 'statistics.orders',
            'group' => 'Статистика',
            'title' => 'Угоди',
        ]);

        $permission = Permission::where('name', 'statistics.offers')->first();
        if(!$permission) Permission::create([
            'name' => 'statistics.offers',
            'group' => 'Статистика',
            'title' => 'Покази',
        ]);

        $permission = Permission::where('name', 'statistics.prices')->first();
        if(!$permission) Permission::create([
            'name' => 'statistics.prices',
            'group' => 'Статистика',
            'title' => 'Ціни',
        ]);
    }
}
