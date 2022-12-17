<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Services\UserServices;

use Illuminate\Http\Request;
use App\Http\Requests\AdditionalUserInfoRequest;
use App\Http\Requests\ChangePasswordRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class AdditionalUserInfoController extends Controller
{
    private $userService;

    public function __construct(UserServices $service)
    {
        $this->userService = $service;
    }

    public function showProfilePage()
    {
        $user = $this->userService->findOneById(Auth::user()->id); 
        return view('pages.customer.profileSetting', compact('user'));
    }

    public function updateUserProfile(AdditionalUserInfoRequest $request)
    {
        $result = $this->userService->updateUserProfile($request);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back()->with('user', $result['user']);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $result = $this->userService->changePassword($request);
        Alert::toast($result['message'], $result['status']);
        return redirect()->back();
    }
}
