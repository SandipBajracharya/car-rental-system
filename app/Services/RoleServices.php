<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

use App\Models\Role;

class RoleServices extends Model
{
    public function findOneByRole($role)
    {
        return Role::where('role', $role)->first();
    }
}