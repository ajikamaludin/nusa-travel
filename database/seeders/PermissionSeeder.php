<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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

            ['id' => Str::uuid(), 'label' => 'Create FAQ', 'name' => 'create-faq'],
            ['id' => Str::uuid(), 'label' => 'Update FAQ', 'name' => 'update-faq'],
            ['id' => Str::uuid(), 'label' => 'View FAQ', 'name' => 'view-faq'],
            ['id' => Str::uuid(), 'label' => 'Delete FAQ', 'name' => 'delete-faq'],

            ['id' => Str::uuid(), 'label' => 'Create Gallery', 'name' => 'create-gallery'],
            ['id' => Str::uuid(), 'label' => 'Update Gallery', 'name' => 'update-gallery'],
            ['id' => Str::uuid(), 'label' => 'View Gallery', 'name' => 'view-gallery'],
            ['id' => Str::uuid(), 'label' => 'Delete Gallery', 'name' => 'delete-gallery'],

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

            ['id' => Str::uuid(), 'label' => 'Create Order', 'name' => 'create-order'],
            ['id' => Str::uuid(), 'label' => 'Update Order', 'name' => 'update-order'],
            ['id' => Str::uuid(), 'label' => 'View Order', 'name' => 'view-order'],
            ['id' => Str::uuid(), 'label' => 'Delete Order', 'name' => 'delete-order'],

            ['id' => Str::uuid(), 'label' => 'Create Car Rental', 'name' => 'create-car-rental'],
            ['id' => Str::uuid(), 'label' => 'Update Car Rental', 'name' => 'update-car-rental'],
            ['id' => Str::uuid(), 'label' => 'View Car Rental', 'name' => 'view-car-rental'],
            ['id' => Str::uuid(), 'label' => 'Delete Car Rental', 'name' => 'delete-car-rental'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat', 'name' => 'create-fastboat'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat', 'name' => 'update-fastboat'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat', 'name' => 'view-fastboat'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat', 'name' => 'delete-fastboat'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat Place', 'name' => 'create-fastboat-place'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Place', 'name' => 'update-fastboat-place'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat Place', 'name' => 'view-fastboat-place'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Place', 'name' => 'delete-fastboat-place'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat Track', 'name' => 'create-fastboat-track'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Track', 'name' => 'update-fastboat-track'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat Track', 'name' => 'view-fastboat-track'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Track', 'name' => 'delete-fastboat-track'],

            ['id' => Str::uuid(), 'label' => 'Create Fastboat Dropoff', 'name' => 'create-fastboat-dropoff'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Dropoff', 'name' => 'update-fastboat-dropoff'],
            ['id' => Str::uuid(), 'label' => 'View Fastboat Dropoff', 'name' => 'view-fastboat-dropoff'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Dropoff', 'name' => 'delete-fastboat-dropoff'],

            ['id' => Str::uuid(), 'label' => 'Create User', 'name' => 'create-user'],
            ['id' => Str::uuid(), 'label' => 'Update User', 'name' => 'update-user'],
            ['id' => Str::uuid(), 'label' => 'View User', 'name' => 'view-user'],
            ['id' => Str::uuid(), 'label' => 'Delete User', 'name' => 'delete-user'],

            ['id' => Str::uuid(), 'label' => 'Create Role', 'name' => 'create-role'],
            ['id' => Str::uuid(), 'label' => 'Update Role', 'name' => 'update-role'],
            ['id' => Str::uuid(), 'label' => 'View Role', 'name' => 'view-role'],
            ['id' => Str::uuid(), 'label' => 'Delete Role', 'name' => 'delete-role'],

            ['id' => Str::uuid(), 'label' => 'Create Promo', 'name' => 'create-promo'],
            ['id' => Str::uuid(), 'label' => 'Update Promo', 'name' => 'update-promo'],
            ['id' => Str::uuid(), 'label' => 'View Promo', 'name' => 'view-promo'],
            ['id' => Str::uuid(), 'label' => 'Delete Promo', 'name' => 'delete-promo'],

            ['id' => Str::uuid(), 'label' => 'Update Setting', 'name' => 'update-setting'],
            ['id' => Str::uuid(), 'label' => 'View Setting', 'name' => 'view-setting'],

            ['id' => Str::uuid(), 'label' => 'Create Agent', 'name' => 'create-agent'],
            ['id' => Str::uuid(), 'label' => 'Update Agent', 'name' => 'update-agent'],
            ['id' => Str::uuid(), 'label' => 'View Agent', 'name' => 'view-agent'],
            ['id' => Str::uuid(), 'label' => 'Delete Agent', 'name' => 'delete-agent'],

            ['id' => Str::uuid(), 'label' => 'View Price Agent', 'name' => 'view-price-agent'],
            ['id' => Str::uuid(), 'label' => 'Create Price Agent', 'name' => 'create-price-agent'],
            ['id' => Str::uuid(), 'label' => 'Update Price Agent', 'name' => 'update-price-agent'],
            ['id' => Str::uuid(), 'label' => 'Delete Price Agent', 'name' => 'delete-price-agent'],

            ['id' => Str::uuid(), 'label' => 'View Fastboat Pickup', 'name' => 'view-fastboat-pickup'],
            ['id' => Str::uuid(), 'label' => 'Create Fastboat Pickup', 'name' => 'create-fastboat-pickup'],
            ['id' => Str::uuid(), 'label' => 'Update Fastboat Pickup', 'name' => 'update-fastboat-pickup'],
            ['id' => Str::uuid(), 'label' => 'Delete Fastboat Pickup', 'name' => 'delete-fastboat-pickup'],

            ['id' => Str::uuid(), 'label' => 'View Unavailable Date', 'name' => 'view-unavailable-date'],
            ['id' => Str::uuid(), 'label' => 'Create Unavailable Date', 'name' => 'create-unavailable-date'],
            ['id' => Str::uuid(), 'label' => 'Update Unavailable Date', 'name' => 'update-unavailable-date'],
            ['id' => Str::uuid(), 'label' => 'Delete Unavailable Date', 'name' => 'delete-unavailable-date'],

            ['id' => Str::uuid(), 'label' => 'Create Globaltix to Track', 'name' => 'create-globaltix-to-track'],
            ['id' => Str::uuid(), 'label' => 'Update Globaltix to Track', 'name' => 'update-globaltix-to-track'],
            ['id' => Str::uuid(), 'label' => 'View Globaltix to Track', 'name' => 'view-globaltix-to-track'],
            ['id' => Str::uuid(), 'label' => 'Delete Globaltix to Track', 'name' => 'delete-globaltix-to-track'],
        ];

        Permission::insert($permissions);

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
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
            'role_id' => $role->id,
        ]);
    }
}
