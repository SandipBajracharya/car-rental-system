<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RoleServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class FacebookSocialiteController extends Controller
{
    private $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleServices();
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('social_id', $user->id)->first();

            if ($finduser) {
                Auth::login($finduser);
                if (Auth::user()->role->role == 'super-admin') {
                    return redirect('/admin/dashboard');
                } else {
                    return redirect('/booking-history');
                }
            } else {
                $role = $this->roleModel->findOneByRole('customer');
                $name = explode(" ", $user->getName());
                $first_name = $name[0];
                $last_name = $name[count($name) - 1];
                $initials = substr($first_name, 0, 1).substr($last_name, 0, 1);

                $newUser = User::updateOrCreate([
                    'social_id' => $user->getId(),
                ],[
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'initials' => $initials,
                    'email' => $user->getEmail(),
                    'password' => Hash::make($user->getName().'@'.$user->getId()),
                    'role_id' => $role->id,
                    'social_id' => $user->getId(),
                    'social_type' => 'facebook',
                    'email_verified_at' => Carbon::now(),
                ]);
            }

            Auth::login($newUser);
            if (Auth::user()->role->role != 'super-admin') {
                return redirect('/booking-history');
            } else {
                return redirect('/admin/dashboard');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}