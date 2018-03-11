<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function change_password(Request $request){
        //dd($request->all());
        $method = $request->isMethod('post');
        if($method){
            $password1 = $request->password1;
            $password2 = $request->password2;
            $validator = Validator::make($request->all(), [
                'password1' => 'required',
                'password2' => 'required'
            ]);
            if($validator->fails()){
                $notification = array(
                    'notify' => 'Both fields are required!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }else if($password1 !== $password2){
                $notification = array(
                    'notify' => 'Passwords must be the same!',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }else{
                //Update password
                $user_id = $request->user_id;
                $update = User::where('id', $user_id)
                    ->update([
                        'password' => Hash::make($password1)
                    ]);
                if($update){
                    $notification = array(
                        'notify' => 'Password updated!',
                        'alert-type' => 'success'
                    );
                    return back()->with($notification);
                }else{
                    return back();
                }
            }
        }else{}
    }
}
