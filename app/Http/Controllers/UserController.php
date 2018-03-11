<?php

namespace App\Http\Controllers;

use App\Libraries\Utilities;
use App\Role;
use App\RoleUser;
use App\User;
use App\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware(['auth','restrictUsers']);
    }

    public function index(Request $request){
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $users = DB::select("select u.name, u.email, u.id, r.role, u.enabled from users as u, roles as r, role_users as ru where 
        u.id = ru.user_id and ru.role_id = r.id and company_id = '$company_id' and u.id != '$user_id'");
        $categories = Role::where('id', '!=', '3')->get();
        return view('users.index', compact('users', 'categories'));
    }
    public function edit_user(Request $request){
        $mode=$_POST['mode'];

        if ($mode=='true') //mode is true when button is enabled
        {
            //Retrive the values from database you want and send using json_encode
            //example
            DB::table('users')->where('id', $_POST['member_id'])
                ->update(['enabled' => '1']);
            $message='User Enabled!!';
            $success='Enabled';
            echo json_encode(array('message'=>$message,'success'=>$success));
        }

        else if ($mode=='false')  //mode is false when button is disabled
        {
            //Retrive the values from database you want and send using json_encode
            //example
            DB::table('users')->where('id', $_POST['member_id'])
                ->update(['enabled' => '2']);
            $message='User disabled!!';
            $success='Disabled';
            echo json_encode(array('message'=>$message,'success'=>$success));

        }
    }
    public function add_user(Request $request){
        $method = $request->isMethod('post');
        $company_id = Auth::user()->company_id;
        if($method){
            //dd($request->file('file'));
            //check if user limit has been exceeded
            //if($current_user_count < $user_limit) {
                $items = $request->item;
                //dd($items);
                if(isset($items)){
                    try{
                        $y = 0;
                        $sum =0;
                        foreach ($items as $item => $value){
                            $user_limit = Utilities::getUserLimit();
                            $current_user_count = Utilities::currentUserCount();
                            if(!($current_user_count == $user_limit)) {
                                $name = $value['name'];
                                $email = $value['email'];
                                $password = $value['password'];
                                $category_id = $value['category_id'];

                                //dd($file_extension);
                                $getCount = User::where('email', $email)->count();
                                if(!isset($value['file'])){
                                    $notification = array(
                                        'notify' => 'You must upload a photo',
                                        'alert-type' => 'error'
                                    );
                                    return back()->withInput()->with($notification);
                                }else{
                                    $file = isset($value['file'])?$value['file']:"";
                                    //validate files
                                    $file_extension = $file->getClientOriginalExtension();
                                    $file_size = $file->getClientSize();
                                    //dd($file_size);
                                    if($file_size > 500000 || $file_size == 0){
                                        $notification = array(
                                            'notify' => 'Photo must not exceed 500kb!',
                                            'alert-type' => 'error'
                                        );
                                        return back()->withInput()->with($notification);
                                    }
                                    if ($file_extension !== 'jpeg' && $file_extension !== 'png' && $file_extension !== 'jpg') {
                                        //return back()->withErrors('Files with .exe format are not allowed')->withInput();
                                        $notification = array(
                                            'notify' => 'Only .png and .jpg files are allowed',
                                            'alert-type' => 'error'
                                        );
                                        return back()->withInput()->with($notification);
                                    }
                                    //dd($file_size);

                                }

                                if(!isset($name, $email, $password, $category_id, $file)){
                                    $notification = array(
                                        'notify' => 'All fields are required!',
                                        'alert-type' => 'error'
                                    );
                                    return back()->withInput()->with($notification);
                                }else if($getCount == 1){
                                    $notification = array(
                                        'notify' => $email.' is already taken!',
                                        'alert-type' => 'error'
                                    );
                                    return back()->withInput()->with($notification);
                                }else{
                                    //create user
                                    $user = User::create([
                                        'name' => $name,
                                        'email' => $email,
                                        'password' => Hash::make($password),
                                        'enabled' => 1,
                                        'role_id' => $category_id,
                                        'company_id' => $company_id
                                    ]);
                                    if($user){
                                        $i = 1;
                                        $user_id = $user->id;
                                        //Create role user
                                        RoleUser::create([
                                            'user_id' => $user_id,
                                            'role_id' => $category_id
                                        ]);

                                        //Add user image
                                        $new_name = base64_encode(date('Y-m-d H:i:s') . $file->getClientOriginalName()) . '.' . $file_extension;
                                        $destinationPath = 'uploads/users';
                                        $file->move($destinationPath, $new_name);
                                        $filename = $destinationPath . '/' . $new_name;
                                        $i++;
                                        $uri = Utilities::generateRequestId($i);
                                        UserPhoto::create([
                                            'user_id' => $user_id,
                                            'original_file_name' => $file->getClientOriginalName(),
                                            'uri' => $uri,
                                            'new_name' => $new_name
                                        ]);
                                        //Notify the user via email
                                        $content = ['password' => $password, 'name' => $name];
                                        Utilities::mailnotifyNewUser($email, $content);
                                        $y++;
                                        $sum += $y;
                                    }

                                }
                            }else{
                                //limit exceeded
                                $notification = array(
                                    'notify' => 'Only '.$sum. ' user(s) added!'.' You have exceeded your limit! You can no longer add users. Upgrade your plan.',
                                    'alert-type' => 'error'
                                );
                                return back()->with($notification);
                            }

                        }
                    }catch (Exception $e){
                        //echo $e->getMessage();
                        $notification = array(
                            'notify' => 'There was an error uploading',
                            'alert-type' => 'error'
                        );
                        return back()->with($notification);
                    }

                    //
                    $notification = array(
                        'notify' => $sum.' user(s) added!',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('users')->with($notification);
                }
//            }else{
//                //limit exceeded
//                $notification = array(
//                    'notify' => 'You have exceeded your limit! You can no longer add users. Upgrade your plan.',
//                    'alert-type' => 'error'
//                );
//                return back()->with($notification);
//            }

        }else{
            //get request
        }
    }

}
