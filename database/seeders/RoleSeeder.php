<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insert_roles = [
            ['role' => 'super-admin'],
            ['role' => 'customer'],
        ];
        Role::insert($insert_roles);
    }
}
