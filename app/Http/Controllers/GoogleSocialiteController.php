<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use Carbon\Carbon;

use App\Models\User;
use App\Services\RoleServices;

class GoogleSocialiteController extends Controller
{
    private $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleServices();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
       
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('social_id', $user->id)->first();
      
            if ($finduser) {
                Auth::login($finduser);
                if (Auth::user()->role->role == 'super-admin') {
                    return redirect('/admin/dashboard');
                } else {
                    return redirect('/customer/home');
                }
            } else {
                $role = $this->roleModel->findOneByRole('customer');
                $initials = substr($user->user['given_name'], 0, 1).substr($user->user['family_name'], 0, 1);
                $newUser = User::create([
                    'first_name' => $user->user['given_name'],
                    'last_name' => $user->user['family_name'],
                    'initials' => $initials,
                    'email' => $user->email,
                    'password' => Hash::make('my-google'),
                    'role_id' => $role->id,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'image' => $user->user['picture'],
                    'email_verified_at' => Carbon::now(),
                ]);

                Auth::login($newUser);
                if (Auth::user()->role->role != 'super-admin') {
                    return redirect('/customer/home');
                } else {
                    return redirect('/admin/dashboard');
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
