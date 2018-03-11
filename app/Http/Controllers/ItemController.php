<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Libraries\Utilities;

class ItemController extends Controller
{
    public function  __construct()
    {
        return $this->middleware('auth');
    }
    public function index(){
        $company_id = Auth::user()->company_id;
        //$categories = Category::orderBy('created_at', 'DESC')->where('company_id', $company_id)->get();
        $items = DB::select("select i.name, i.code, i.date_added, c.name as category, u.name as user_name from items as i, categories as c, users as u 
        where i.category_id = c.id and i.created_by = u.id and i.company_id = '$company_id' order by i.created_at DESC");
        return view('items.index', compact('items'));
    }
    public function add_item(Request $request){
        $method = $request->isMethod('post');
        $categories = Category::all();
        if($method){ //Process form
            //Check if limit has/has not been exceeded
            $item_limit = Utilities::getItemLimit();
            $item_count = Utilities::currentItemCount();
            if($item_count < $item_limit) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|unique:items',
                    'code' => 'required|unique:items',
                    'category_id' => 'required',
                    'date_added' => 'required|date',
                    'description' => 'required'
                ]);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                }
                $create = Item::create([
                    'name' => $request->name,
                    'code' => $request->code,
                    'category_id' => $request->category_id,
                    'date_added' => date('Y-m-d H:i:s', strtotime($request->date_added)),
                    'created_by' => Auth::user()->id,
                    'description' => $request->description,
                    'company_id' => Auth::user()->company_id
                ]);
                if ($create) {
                    //return back()->with('message', 'New item added!');
                    //Update item uri
                    $item_id = $create->id;
                    $item_uri = Utilities::generateRequestId($item_id);
                    DB::table('items')->where('id', $item_id)
                        ->update([
                            'uri' => $item_uri
                        ]);
                    //Add to stocks
                    Stock::create([
                        'item_id' => $create->id,
                        'prev_quantity' => 0,
                        'current_quantity' => 0
                    ]);
                    $notification = array(
                        'notify' => 'New item added',
                        'alert-type' => 'success'
                    );
                    return redirect()->route('items')->with($notification);
                } else {
                    return back()->withErrors('Unable to add item, try again!');
                }
            }else{
                $notification = array(
                    'notify' => 'You have exceeded your limit! You can no longer add items. Upgrade your plan.',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }
        }else{ //Display form
            return view('items.create',compact('categories'));
        }
    }
}


