<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Utilities;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $role_id = Utilities::getUserRole($user_id);
        //pending requests
        if($role_id == 1){ //store keeper
            $requests = DB::select("select s.prev_quantity, s.current_quantity, r.created_at as created_at, i.name as item, c.category as category, u.name as fullname, rs.status as status, r.quantity, r.status as status_id, r.reason as reason, r.id as request_id
            from items as i, request_categories as c, requests as r, requests_status as rs, users as u, stocks as s where 
            i.id = r.item_id and i.id = s.item_id and c.id = r.request_category and rs.id = r.status and u.id = r.added_by and r.added_by = '$user_id' and r.status = 1 order by r.created_at DESC LIMIT 5");
        }else{ //supervisor, etc.
            $requests = DB::select("select r.created_at as created_at, s.prev_quantity, s.current_quantity, i.name as item, c.category as category, u.name as fullname, rs.status as status, r.quantity, r.status as status_id, r.reason as reason, r.id as request_id
            from items as i, request_categories as c, requests as r, requests_status as rs, users as u, stocks as s where 
            i.id = r.item_id and i.id = s.item_id and c.id = r.request_category and rs.id = r.status and u.id = r.added_by and r.status = 1  order by r.created_at DESC LIMIT 5");
        }
        $stocks = DB::select("select i.id as item_id, i.uri, s.prev_quantity, s.current_quantity, i.name as item_name, i.code, c.name as category from stocks as s, items as i, categories as c
            where s.item_id = i.id and c.id = i.category_id order by s.current_quantity ASC LIMIT 5");

        return view('dashboard', compact('requests', 'stocks'));
    }
}
