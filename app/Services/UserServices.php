<?php

namespace App\services;

use App\Models\AdditionalUserInfo;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserServices
{
    public function findOneById($id)
    {
        return User::find($id);
    }

    public function findUserInfoByUserid($id)
    {
        return AdditionalUserInfo::where('user_id', $id)->first();
    }

    public function updateUserProfile($inputs)
    {
        // user additional info
        $userinfo = [
            'user_id' => Auth::user()->id,
            'document_type' => $inputs->document_type,
            'document_number' => $inputs->document_number,
            'dob' => $inputs->dob
        ];

        if ($inputs->hasFile('document_image')) {
            $FilenameWithExtension = $inputs['document_image']->getClientOriginalName();
            $Filename = pathinfo($FilenameWithExtension, PATHINFO_FILENAME);
            $ext = $inputs['document_image']->getClientOriginalExtension();
            $name = $Filename.'_'.time().'.'.$ext;
            $inputs['document_image']->move(public_path().'/images/userDocument/', $name);  
            $filenamesToStore = $name;
            $userDetail = $this->findUserInfoByUserid(Auth::user()->id);
            if (!empty($userDetail->document_image)) {
                Storage::disk('public_disk')->delete('images/userDocument/'. $userDetail->document_image);
            }
        }

        if (isset($filenamesToStore)) {
            $userinfo['document_image'] = $filenamesToStore;
        }

        // user update
        if ($inputs->hasFile('image')) {
            $FileWithExtension = $inputs['image']->getClientOriginalName();
            $fn = pathinfo($FileWithExtension, PATHINFO_FILENAME);
            $extention = $inputs['image']->getClientOriginalExtension();
            $fname = $fn.'_'.time().'.'.$extention;
            $inputs['image']->move(public_path().'/images/profilePictures/', $fname);  
            $filenameToStore = $fname;
            if (!empty(Auth::user()->image)) {
                Storage::disk('public_disk')->delete('images/profilePictures/'. Auth::user()->image);
            }
        }

        $name_arr = explode(" ", $inputs->name);
        $last_index = count($name_arr) - 1;
        $userUpdate = [
            'first_name' => $name_arr[0],
            'last_name' => $name_arr[$last_index],
            'gender' => $inputs->gender,
            'can_reserve' => 1
        ];

        if (isset($filenameToStore)) {
            $userUpdate['image'] = $filenameToStore;
        }

        $user = $this->findOneById(Auth::user()->id);

        try {
            AdditionalUserInfo::updateOrCreate(
                [
                    'user_id' => Auth::user()->id
                ],
                $userinfo
            );
            User::where('id', Auth::user()->id)->update($userUpdate);
            $result = ['status' => 'success', 'message' => 'Profile Updated successfully.', 'user' => $user];
        } catch (\Throwable $e) {
            $result = ['status' => 'error', 'message' => $e->getMessage(), 'user' => $user];
        }
        return $result;
    }

    public function changePassword($inputs)
    {
        $hashedPassword = Auth::user()->password;
        if (Hash::check($inputs->old_password, $hashedPassword)) {
            $update = [
                'password' => Hash::make($inputs->password)
            ];
            User::where('id', Auth::user()->id)->update($update);
            $result = ['status' => 'success', 'message' => 'Password changed successfully.'];
        } else {
            $result = ['status' => 'error', 'message' => 'Old pasword did not match.'];
        }

        return $result;
    }
}