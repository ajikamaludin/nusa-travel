<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['id' => Str::uuid(), 'label' => 'View Dashboard', 'name' => 'view-dashboard'],

            ['id' => Str::uuid(), 'label' => 'Create Post', 'name' => 'create-post'],
            ['id' => Str::uuid(), 'label' => 'Update Post', 'name' => 'update-post'],
            ['id' => Str::uuid(), 'label' => 'View Post', 'name' => 'view-post'],
            ['id' => Str::uuid(), 'label' => 'Delete Post', 'name' => 'delete-post'],

            ['id' => Str::uuid(), 'label' => 'Create Page', 'name' => 'create-page'],
            ['id' => Str::uuid(), 'label' => 'Update Page', 'name' => 'update-page'],
            ['id' => Str::uuid(), 'label' => 'View Page', 'name' => 'view-page'],
            ['id' => Str::uuid(), 'label' => 'Delete Page', 'name' => 'delete-page'],

            ['id' => Str::uuid(), 'label' => 'Create Tag', 'name' => 'create-tag'],
            ['id' => Str::uuid(), 'label' => 'Update Tag', 'name' => 'update-tag'],
            ['id' => Str::uuid(), 'label' => 'View Tag', 'name' => 'view-tag'],
            ['id' => Str::uuid(), 'label' => 'Delete Tag', 'name' => 'delete-tag'],

            ['id' => Str::uuid(), 'label' => 'Create Customer', 'name' => 'create-customer'],
            ['id' => Str::uuid(), 'label' => 'Update Customer', 'name' => 'update-customer'],
            ['id' => Str::uuid(), 'label' => 'View Customer', 'name' => 'view-customer'],
            ['id' => Str::uuid(), 'label' => 'Delete Customer', 'name' => 'delete-customer'],

            ['id' => Str::uuid(), 'label' => 'Create Tour Package', 'name' => 'create-tour-package'],
            ['id' => Str::uuid(), 'label' => 'Update Tour Package', 'name' => 'update-tour-package'],
            ['id' => Str::uuid(), 'label' => 'View Tour Package', 'name' => 'view-tour-package'],
            ['id' => Str::uuid(), 'label' => 'Delete Tour Package', 'name' => 'delete-tour-package'],

            ['id' => Str::uuid(), 'label' => 'Create Tour Package Order', 'name' => 'create-tour-package-order'],
            ['id' => Str::uuid(), 'label' => 'Update Tour Package Order', 'name' => 'update-tour-package-order'],
            ['id' => Str::uuid(), 'label' => 'View Tour Package Order', 'name' => 'view-tour-package-order'],
            ['id' => Str::uuid(), 'label' => 'Delete Tour Package Order', 'name' => 'delete-tour-package-order'],

            ['id' => Str::uuid(), 'label' => 'Create Car Rental', 'name' => 'create-car-rental'],
            ['id' => Str::uuid(), 'label' => 'Update Car Rental', 'name' => 'update-car-rental'],
            ['id' => Str::uuid(), 'label' => 'View Car Rental', 'name' => 'view-car-rental'],
            ['id' => Str::uuid(), 'label' => 'Delete Car Rental', 'name' => 'delete-car-rental'],

            ['id' => Str::uuid(), 'label' => 'Create Car Rental Order', 'name' => 'create-car-rental-order'],
            ['id' => Str::uuid(), 'label' => 'Update Car Rental Order', 'name' => 'update-car-rental-order'],
            ['id' => Str::uuid(), 'label' => 'View Car Rental Order', 'name' => 'view-car-rental-order'],
            ['id' => Str::uuid(), 'label' => 'Delete Car Rental Order', 'name' => 'delete-car-rental-order'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat Place', 'name' => 'create-fastboat-place'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Place', 'name' => 'update-fastboat-place'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat Place', 'name' => 'view-fastboat-place'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Place', 'name' => 'delete-fastboat-place'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat Track', 'name' => 'create-fastboat-track'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Track', 'name' => 'update-fastboat-track'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat Track', 'name' => 'view-fastboat-track'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Track', 'name' => 'delete-fastboat-track'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat Order', 'name' => 'create-fastboat-order'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Order', 'name' => 'update-fastboat-order'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat Order', 'name' => 'view-fastboat-order'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Order', 'name' => 'delete-fastboat-order'],

            ['id' => Str::uuid(), 'label' => 'Create User', 'name' => 'create-user'],
            ['id' => Str::uuid(), 'label' => 'Update User', 'name' => 'update-user'],
            ['id' => Str::uuid(), 'label' => 'View User', 'name' => 'view-user'],
            ['id' => Str::uuid(), 'label' => 'Delete User', 'name' => 'delete-user'],

            ['id' => Str::uuid(), 'label' => 'Create Role', 'name' => 'create-role'],
            ['id' => Str::uuid(), 'label' => 'Update Role', 'name' => 'update-role'],
            ['id' => Str::uuid(), 'label' => 'View Role', 'name' => 'view-role'],
            ['id' => Str::uuid(), 'label' => 'Delete Role', 'name' => 'delete-role'],

            ['id' => Str::uuid(), 'label' => 'Update Setting', 'name' => 'update-setting'],
            ['id' => Str::uuid(), 'label' => 'View Setting', 'name' => 'view-setting'],
        ];

        foreach($permissions as $permission) {
            Permission::insert($permission);
        }

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::all();
        foreach($permissions as $permission) {
            $role->rolePermissions()->create(['permission_id' => $permission->id]);
        }

        User::create([
            'name' => 'Super Administrator',
            'email' => 'root@admin.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Administator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => $role->id
        ]);
    }
}
