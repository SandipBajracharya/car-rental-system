<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Socialite;
use Auth;
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
                return redirect('/home');
            } else {
                $role = $this->roleModel->findOneByRole('customer');
                
                $newUser = User::create([
                    'first_name' => $user->user['given_name'],
                    'last_name' => $user->user['family_name'],
                    'email' => $user->email,
                    'password' => Hash::make('my-google'),
                    'role_id' => $role->id,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'email_verified' => $user->user['email_verified'],
                    'email_verified_at' => Carbon::now(),
                ]);
     
                Auth::login($newUser);
                return redirect('/home');
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
