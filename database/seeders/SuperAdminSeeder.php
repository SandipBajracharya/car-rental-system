<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Services\RoleServices;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleModel = new RoleServices();
        $role = $roleModel->findOneByRole('super-admin');
        $user = [
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'sndp106.sb@gmail.com',
            'password' => Hash::make('admin@123'),
            'role_id' => $role->id,
            'is_admin_account' => 1,
        ];

        User::create($user);
    }
}
