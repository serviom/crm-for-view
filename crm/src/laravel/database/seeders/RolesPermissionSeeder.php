<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'SeniorAgent' => [
                [
                    'group' => 'Клієнти',
                    'permission' => [
                        'clients.view',
                        'clients.viewMyOnly',
                        'clients.create',
                        'clients.update',
                        'clients.delete',
                    ],
                ], // Клієнти
                [
                    'group' => 'Об\'єкти',
                    'permission' => [
                        'objects.view',
                        'objects.viewMyOnly',
                        'objects.create',
                        'objects.update',
                        'objects.delete',
                    ],
                ], // Об'єкти
                [
                    'group' => 'Статистика',
                    'permission' => [
                        'statistics.clients',
                        'statistics.prices',
                    ],
                ], // Статистика
                [
                    'group' => 'Користувачі',
                    'permission' => [
                        'users.view',
                        'users.viewMyOnly',
                        'users.viewAny'
                    ],
                ], // Користувачі
            ],
            'Admin' => [
                [
                    'group' => 'Клієнти',
                    'permission' => [
                        'clients.viewAny',
                        'clients.view',
                        'clients.create',
                        'clients.update',
                    ],
                ], // Клієнти
                [
                    'group' => 'Об\'єкти',
                    'permission' => [
                        'objects.view',
                        'objects.viewMyOnly',
                        'objects.create',
                        'objects.update',
                        'objects.delete',
                    ],
                ], // Об'єкти
                [
                    'group' => 'Статистика',
                    'permission' => [
                        'statistics.clients',
                        'statistics.prices',
                        'statistics.offers',
                        'statistics.prices',
                        'statistics.viewAny'
                    ],
                ], // Статистика
                [
                    'group' => 'Користувачі',
                    'permission' => [
                        'users.view',
                        'users.viewAny',
                        'users.create',
                        'users.update',
                        'users.delete',
                    ],
                ], // Користувачі
                [
                    'group' => 'Лог дій',
                    'permission' => [
                        'actions.viewAny',
                        'actions.view',
                    ],
                ], // Лог дій
                [
                    'group' => 'Етапи угоди',
                    'permission' => [
                        'stage_agreement.view',
                        'stage_agreement.create',
                        'stage_agreement.update',
                        'stage_agreement.delete',
                    ],
                ], // Довідники (Етапи угоди)
                [
                    'group' => 'Райони',
                    'permission' => [
                        'districts.view',
                        'districts.create',
                        'districts.update',
                        'districts.delete',
                    ],
                ], // Довідники (Райони)
                [
                    'group' => 'Джерела надходження',
                    'permission' => [
                        'income_source.view',
                        'income_source.create',
                        'income_source.update',
                        'income_source.delete',
                    ],
                ], // Довідники (Джерела надходження)
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::where('name', $name)->first();

            if ($role) {
                foreach ($data as $v) {
                    $permissions = Permission::where('group', $v['group'])->get();
                    if ($permissions) {
                        $this->checkPermission($permissions, $v['permission'], $role->id);
                    }
                }
            }
        }
    }

    private function checkPermission($permissions, $permissionList, $roleID)
    {
        foreach ($permissions as $p) {
            if(
                in_array($p->name, $permissionList)
                && !db::table('role_has_permissions')
                    ->where('role_id', $roleID)
                    ->where('permission_id', $p->id)
                    ->first()
            ) {
                db::table('role_has_permissions')
                    ->insert([
                        'role_id' => $roleID,
                        'permission_id' => $p->id,
                    ]);
            }
        }
    }
}
