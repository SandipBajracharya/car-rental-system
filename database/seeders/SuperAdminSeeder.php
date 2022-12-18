<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Services\RoleServices;

use Carbon\Carbon;

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
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'initials' => 'AA',
            'email' => 'sndp6.sb@gmail.com',
            'password' => Hash::make('admin@123'),
            'role_id' => $role->id,
            'email_verified_at' => Carbon::now()
        ];

        User::create($user);
    }
}
