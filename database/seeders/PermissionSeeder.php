<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            ['label' => 'Create Post', 'name' => 'create-post'],
            ['label' => 'Update Post', 'name' => 'update-post'],
            ['label' => 'View Post', 'name' => 'view-post'],
            ['label' => 'Delete Post', 'name' => 'delete-post'],
        ];
    }
}
