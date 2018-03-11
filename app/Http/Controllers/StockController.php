<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(Request $request){
        $method = $request->isMethod('post');
        if($method){

        }else{
            $stocks = DB::select("select i.id as item_id, i.uri, s.prev_quantity, s.current_quantity, i.name as item_name, i.code, c.name as category from stocks as s, items as i, categories as c
            where s.item_id = i.id and c.id = i.category_id");
            //dd($stocks);
            return view('stocks.index', compact('stocks'));
        }
    }
    public function view_requests(Request $request, $uri){
        $item_id = Item::where('uri', $uri)->first()->id;
        $item_name = Item::where('uri', $uri)->first()->name;
        //dd($item_id);
        $requests = DB::select("select r.quantity, r.reason, u.name, r.created_at, rc.category, rs.status from requests as r, users as u, 
        request_categories as rc, requests_status as rs where r.request_category = rc.id and r.added_by = u.id and r.status = rs.id and 
        r.item_id = '$item_id'order by r.created_at desc");
       return view('stocks.requests', compact('requests', 'item_name'));
    }
}
