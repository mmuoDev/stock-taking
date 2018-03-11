<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\RoleUser;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use App\Libraries\Utilities;
use App\UserPhoto;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'file' => 'mimes:jpeg,jpg,png,gif|required|max:500'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => 3//Super-admin

        ]);
        if($user){
            $company = Company::create([
               'company' => $data['name'],
                'item_limit' => env("ITEM_LIMIT"),
                'request_limit' => env("REQUEST_LIMIT"),
                'category_limit' => env("CATEGORY_LIMIT"),
                'user_limit' => env('USER_LIMIT')
            ]);
            //assign user to role
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => 3
            ]);
            //create user photo
            $file = $data['file'];
            $file_extension = $file->getClientOriginalExtension();
            $new_name = base64_encode(date('Y-m-d H:i:s') . $file->getClientOriginalName()) . '.' . $file_extension;
            $destinationPath = 'uploads/users';
            $file->move($destinationPath, $new_name);
            $filename = $destinationPath . '/' . $new_name;

            $uri = Utilities::generateRequestId($user->id);
            UserPhoto::create([
                'user_id' => $user->id,
                'original_file_name' => $file->getClientOriginalName(),
                'uri' => $uri,
                'new_name' => $new_name
            ]);
            //create company profile
            if($company){
                $company_id = $company->id;
                $user_id = $user->id;
                DB::table('users')
                    ->where('id', $user_id)
                    ->update([
                        'company_id' => $company_id
                    ]);
            }
            //Mail new created user
            $email = $data['email'];
            $content = ['name' => $data['name'], 'item_limit' => env('ITEM_LIMIT'),
                'request_limit' => env("REQUEST_LIMIT"),
                'category_limit' => env("CATEGORY_LIMIT"),
                'user_limit' => env('USER_LIMIT')
                ];
            Utilities::notifyNewAdminUsers($email, $content);
        }
        return $user;
    }
}
