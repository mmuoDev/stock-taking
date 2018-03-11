<?php
namespace App\Libraries;

use App\Category;
use App\Company;
use App\Item;
use App\Mail\notifyNewAdminUsers;
use App\Notifications\notifySupervisorOfRequests;
use App\Notifications\notifyStoreKeeperOfRequestStatus;
use App\Request;
use App\RequestComment;
use App\User;
use App\UserPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Mail;
use Illuminate\Support\Facades\Auth;

class Utilities
{
    public static $abcVar = '';

//    public function __construct()
//    {
//        $company_id = Auth::user()->company_id;
//        self::$abcVar = 4;
//    }

    public static function itemsPerCategory(){

    }
    public static function getItemLimit(){
        $company_id = Auth::user()->company_id;
        $data = Company::where('id', $company_id)->pluck('item_limit')->first();
        return $data;
    }
    public static function currentItemCount(){
        $company_id = Auth::user()->company_id;
        $item_count = Item::where('company_id', $company_id)->count();
        return $item_count;
    }
    public static function getRequestLimit(){
        $company_id = Auth::user()->company_id;
        $data = Company::where('id', $company_id)->pluck('request_limit')->first();
        return $data;
    }
    public static function currentRequestCount(){
        $company_id = Auth::user()->company_id;
        $request_count = Request::where('company_id', $company_id)->count();
        return $request_count;
    }
    public static function getUserLimit(){
        $company_id = Auth::user()->company_id;
        $data = Company::where('id', $company_id)->pluck('user_limit')->first();
        return $data;
    }
    public static function currentUserCount(){
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $user_count = User::where('company_id', $company_id)
            ->where('id', '!=', $user_id)->count();
        return $user_count;
    }
    public static function getCategoryLimit(){
        $company_id = Auth::user()->company_id;
        $data = Company::where('id', $company_id)->pluck('category_limit')->first();
        return $data;
    }
    public static function currentCategoryCount(){
        $company_id = Auth::user()->company_id;
        $category_count = Category::where('company_id', $company_id)->count();
        return $category_count;
    }
    public static function getRole($user_id){
        $roles = DB::select("select r.role from users as u, role_users as ru, roles as r where u.id = ru.user_id and ru.role_id = r.id and 
        u.id = '$user_id'");
        foreach ($roles as $role){
            $role = $role->role;
        }
        return $role;
    }
    public static function getUserPhoto($user_id){
        $data = UserPhoto::where('user_id', $user_id)->count();
            //->first()->new_name;
        if($data == 1){
            $photo = UserPhoto::where('user_id', $user_id)->first()->new_name;
        }else{
            $photo = "default_user.png";
        }
        //dd($data);exit;
        return $photo;
    }
    public static function getUserRole($user_id){
        $roles = DB::select("select r.id from users as u, role_users as ru, roles as r where u.id = ru.user_id and ru.role_id = r.id and 
        u.id = '$user_id'");
        foreach ($roles as $role){
            $role_id = $role->id;
        }
        return $role_id;
    }
    public static function getSupervisorComments($request_id){
        $comments = RequestComment::where('request_id', $request_id)->get();
        $comments = DB::select("select c.comment,c.created_at as created_at, u.name as name from requests_comments as c, users as u where 
        c.user_id = u.id");
        return $comments;
    }
    public static function notifySupervisorOfRequest($request_id, $item_name){
        $users = User::where('role_id', 2)->get();
        return Notification::send($users, new notifySupervisorOfRequests($request_id, $item_name));
    }
    public static function notifyStoreKeeperOfRequestStatus($request_id, $item_name, $user_id){
        $users = User::where('id', $user_id)->get();
        return Notification::send($users, new notifyStoreKeeperOfRequestStatus($request_id, $item_name));
    }
    public static function generateRequestId($i = null)
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        } else {
            return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        }
    }
    public static function sendMailToNotifySupervisorOfRequests($email, $content){
        try {
            $send_mail = Mail::to($email)->send(new \App\Mail\notifySupervisorOfRequests($content));
        } catch (Exception $e) {
        }

    }
    //users added by super admin
    public static function mailnotifyNewUser($email, $content){
        try {
            $send_mail = Mail::to($email)->send(new \App\Mail\mailnotifyNewUser($content));
        } catch (Exception $e) {
        }
    }
    public static function notifyStoreKeeperOfRequestChange($email, $content){
        try {
            $send_mail = Mail::to($email)->send(new \App\Mail\notifyStoreKeeperOfRequestStatus($content));
        } catch (Exception $e) {
        }

    }
    public static function notifyNewAdminUsers($email, $content){
        try {
            $send_mail = Mail::to($email)->send(new notifyNewAdminUsers($content));
        } catch (Exception $e) {
        }
    }
}