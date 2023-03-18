<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FastboatagentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->Agent();
        $this->Permission();
    }
    public function Agent()
    {
        Customer::create([
            'name' => 'Agent Dummy',
            'email' => 'agent@mail.com',
            'phone' => '0812312234234',
            'password' => bcrypt('admin'),
            'address' => 'indonesia',
            'nation' => Customer::WNI,
            'is_active' => Customer::ACTIVE,
            'email_varified_at' => now(),
            'is_agent'=>Customer::ACTIVE,
            'token'=>Hash::make(Str::random(10))
        ]);
    }
    public function Permission(){
        $permissions=[
            ['id' => Str::uuid(), 'label' => 'Create Agent', 'name' => 'create-agent'],
            ['id' => Str::uuid(), 'label' => 'Update Agent', 'name' => 'update-agent'],
            ['id' => Str::uuid(), 'label' => 'View Agent', 'name' => 'view-agent'],
            ['id' => Str::uuid(), 'label' => 'Delete Agent', 'name' => 'delete-agent'],

            ['id' => Str::uuid(), 'label' => 'View Price Agent', 'name' => 'view-price-agent'],
            ['id' => Str::uuid(), 'label' => 'Create Price Agent', 'name' => 'create-price-agent'],
            ['id' => Str::uuid(), 'label' => 'Update Price Agent', 'name' => 'update-price-agent'],
            ['id' => Str::uuid(), 'label' => 'Delete Price Agent', 'name' => 'delete-price-agent'],
        ];
        foreach ($permissions as $permission) {
            Permission::insert($permission);
        }
        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $role->rolePermissions()->create(['permission_id' => $permission->id]);
        }
    }
}
