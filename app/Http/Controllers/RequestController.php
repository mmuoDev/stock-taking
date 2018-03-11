<?php


namespace App\Http\Controllers;

use App\Item;
use App\Libraries\Utilities;
use App\RequestCategory;
use App\RequestComment;
use App\RequestStatusLog;
use App\Stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class RequestController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index(Request $request){
        //Fetch all requests
        //Get user role
        $user_id = Auth::user()->id;
        $role_id = Utilities::getUserRole($user_id);
        $statuses = DB::select("select * from requests_status where id != 1"); //Get only approve and decline
        $company_id = Auth::user()->company_id;
        //dd($role_id);
        $method = $request->isMethod('post');
        if($method){
            //Update status of request
            $validator = Validator::make($request->all(), [
                'status_id' => 'required'
            ]);
            if($validator->fails()){
                $notification = array(
                    'notify' => 'Please select a status',
                    'alert-type' => 'error'
                );
                return back()->withInput()->with($notification);
            }

            $status_id = $request->status_id;
            $requests = \App\Request::where('id', $request->request_id)->first();
            $category = $requests->request_category;
            $added_by = $requests->added_by;
            $users = User::where('id', $added_by)->first();
            $user_email = $users->email;
            $requested_quantity = $requests->quantity;
            $item_id = $requests->item_id;
            $stocks = Stock::where('item_id', $item_id)->first();
            $current_stock = $stocks->current_quantity;
            //$prev_stock = $stocks->prev_quantity;
            $uri = $requests->uri;
            $items = Item::where('id', $item_id)->first();
            $item_name = $items->name;
            if($status_id == 2){ //if approved by supervisor

                //Update stock for this item
                if($category == 2){ //remove from stock
                    if($requested_quantity <= $current_stock){
                      //update stocks
                      $current_quantity = $current_stock - $requested_quantity;
                      DB::table('stocks')->where('item_id', $item_id)
                          ->update([
                              'prev_quantity' => $current_stock,
                              'current_quantity' => $current_quantity
                          ]);
                    }else{
                        //throw error
                        $notification = array(
                            'notify' => 'Requested quantity can\'t be more than the current stock for this request',
                            'alert-type' => 'error'
                        );
                        return back()->withInput()->with($notification);
                    }
                }else{ //add to stock
                    $current_quantity = $current_stock + $requested_quantity;
                    $prev_quantity = $current_stock;
                    DB::table('stocks')->where('item_id', $item_id)
                        ->update([
                            'prev_quantity' => $prev_quantity,
                            'current_quantity' => $current_quantity
                        ]);
                }

            }
            //Comments
            if(isset($request->comments)){
                RequestComment::create([
                    'comment' => $request->comments,
                    'user_id' => $user_id,
                    'request_id' => $request->request_id
                ]);
            }
            //Update status in requests table
            DB::table('requests')
                ->where('id', $request->request_id)
                ->update([
                    'status' => $request->status_id
                ]);
            //Log into request status log
            RequestStatusLog::create([
                'request_id' => $request->request_id,
                'user_id' => $user_id,
                'status' => $request->status_id
            ]);
            //Send notification that status of request has changed.
            Utilities::notifyStoreKeeperOfRequestStatus($uri, $item_name, $added_by);
            //Send Mail via Email
            $content = ['item' => $item_name, 'request_uri' => $uri];
            Utilities::notifyStoreKeeperOfRequestChange($user_email, $content);
            $notification = array(
                'notify' => 'Status updated!',
                'alert-type' => 'success'
            );
            return back()->with($notification);

        }else{
            if($role_id == 1){ //store keeper
                $requests = DB::select("select s.prev_quantity, s.current_quantity, r.created_at as created_at, i.name as item, 
            c.category as category, u.name as fullname, rs.status as status, r.quantity, r.status as status_id, r.reason as reason, 
            r.id as request_id
            from items as i, request_categories as c, requests as r, requests_status as rs, users as u, stocks as s where 
            i.id = r.item_id and r.item_id = s.item_id and c.id = r.request_category and rs.id = r.status and u.id = r.added_by 
             and r.added_by = '$user_id'  and r.company_id = '$company_id'
            order by r.created_at DESC");
                //dd($requests);
            }else{ //supervisor, etc.
                $requests = DB::select("select r.created_at as created_at, s.prev_quantity, s.current_quantity, i.name as item, c.category as category, u.name as fullname, rs.status as status, r.quantity, r.status as status_id, r.reason as reason, r.id as request_id
            from items as i, request_categories as c, requests as r, requests_status as rs, users as u, stocks as s where 
            i.id = r.item_id and i.id = s.item_id and c.id = r.request_category and rs.id = r.status and u.id = r.added_by and r.company_id = '$company_id'  order by r.created_at DESC");
            }
            //dd($requests);
            return view('requests.index', compact('requests', 'statuses'));
        }

    }
    public function get_request(Request $request, $uri){
        $user_id = Auth::user()->id;
        $role_id = Utilities::getUserRole($user_id);
        $data = \App\Request::where('uri', $uri)->first();
        $id = $data->id;
        $statuses = DB::select("select * from requests_status where id != 1"); //Get only approve and decline
        //dd($id);
        $method = $request->isMethod('post');
        if($method){
            //Update status of request
            $validator = Validator::make($request->all(), [
                'status_id' => 'required'
            ]);
            if($validator->fails()){
                $notification = array(
                    'notify' => 'Please select a status',
                    'alert-type' => 'error'
                );
                return back()->withInput()->with($notification);
            }

            $status_id = $request->status_id;
            $requests = \App\Request::where('id', $request->request_id)->first();
            $category = $requests->request_category;
            $added_by = $requests->added_by;
            $users = User::where('id', $added_by)->first();
            $user_email = $users->email;
            $requested_quantity = $requests->quantity;
            $item_id = $requests->item_id;
            $stocks = Stock::where('item_id', $item_id)->first();
            $current_stock = $stocks->current_quantity;
            $uri = $requests->uri;
            $items = Item::where('id', $item_id)->first();
            $item_name = $items->name;
            if($status_id == 2){ //if approved by supervisor

                //Update stock for this item
                if($category == 2){ //remove from stock
                    if($requested_quantity <= $current_stock){
                        //update stocks
                        $current_quantity = $current_stock - $requested_quantity;
                        DB::table('stocks')->where('item_id', $item_id)
                            ->update([
                                'prev_quantity' => $current_stock,
                                'current_quantity' => $current_quantity
                            ]);
                    }else{
                        //throw error
                        $notification = array(
                            'notify' => 'Requested quantity can\'t be more than the current stock for this request',
                            'alert-type' => 'error'
                        );
                        return back()->withInput()->with($notification);
                    }
                }else{ //add to stock
                    $current_quantity = $current_stock + $requested_quantity;
                    $prev_quantity = $current_stock;
                    DB::table('stocks')->where('item_id', $item_id)
                        ->update([
                            'prev_quantity' => $prev_quantity,
                            'current_quantity' => $current_quantity
                        ]);
                }

            }
            //Comments
            if(isset($request->comments)){
                RequestComment::create([
                    'comment' => $request->comments,
                    'user_id' => $user_id,
                    'request_id' => $request->request_id
                ]);
            }
            //Update status in requests table
            DB::table('requests')
                ->where('id', $request->request_id)
                ->update([
                    'status' => $request->status_id
                ]);
            //Log into request status log
            RequestStatusLog::create([
                'request_id' => $request->request_id,
                'user_id' => $user_id,
                'status' => $request->status_id
            ]);
            //Send notification that status of request has changed.
            Utilities::notifyStoreKeeperOfRequestStatus($uri, $item_name, $added_by);
            //Send Mail via Email
            $content = ['item' => $item_name, 'request_uri' => $uri];
            Utilities::notifyStoreKeeperOfRequestChange($user_email, $content);
            $notification = array(
                'notify' => 'Status updated!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            if($role_id == 1) { //store keeper
                $requests = DB::select("select s.prev_quantity, s.current_quantity, r.created_at as created_at, i.name as item, c.category as category, u.name as fullname, rs.status as status, r.quantity, r.status as status_id, r.reason as reason, r.id as request_id
            from items as i, request_categories as c, requests as r, requests_status as rs, users as u, stocks as s where 
            i.id = r.item_id and c.id = r.request_category and i.id = s.item_id and rs.id = r.status and u.id = r.added_by and r.id = '$id' and r.added_by = '$user_id'  order by r.created_at DESC");
            }else{
                $requests = DB::select("select s.prev_quantity, s.current_quantity, r.created_at as created_at, i.name as item, c.category as category, u.name as fullname, rs.status as status, r.quantity, r.status as status_id, r.reason as reason, r.id as request_id
            from items as i, request_categories as c, requests as r, requests_status as rs, users as u, stocks as s where 
            i.id = r.item_id and c.id = r.request_category and i.id = s.item_id and rs.id = r.status and u.id = r.added_by and r.id = '$id'  order by r.created_at DESC");
            }
            return view('requests.request', compact('requests', 'statuses'));
        }

    }
    public function new_request(Request $request){
        $method = $request->isMethod('post');
        $items = Item::all();
        $items = DB::select("select i.id as item_id, i.name as item_name, s.current_quantity from items as i, stocks as s where i.id = s.item_id");
        $categories = RequestCategory::all();

        if($method){
            //dd($request->item);
            if(isset($request->item)){
                $items = $request->item;
               // dd(count($items));
                $i = 0;
                $sum = 0;
                foreach ($items as $key => $value){

                    //$array[] = $value['item_id'];
                    //Validate
                    $request_limit = Utilities::getRequestLimit();
                    $request_count = Utilities::currentRequestCount();
                    //dd($request_count);
                    if(!($request_count == $request_limit)){
                        $item_id = $value['item_id'];
                        $category_id = $value['category_id'];
                        $quantity = $value['quantity'];
                        $reason = $value['reason'];

                        if(!isset($quantity, $reason)){
                            $notification = array(
                                'notify' => 'All fields are required!',
                                'alert-type' => 'error'
                            );
                            return back()->withInput()->with($notification);
                        }else{
                            $user_id = Auth::user()->id;
                            $company_id = Auth::user()->company_id;
                            //dd($request->item);
                            $requests = \App\Request::create([
                                'request_category' => $category_id,
                                'quantity' => $quantity,
                                'reason' => $reason,
                                'item_id' => $item_id,
                                'status' => 1, //default status = pending
                                'added_by' => $user_id,
                                'company_id' => $company_id
                            ]);
                            $i++;
                            $sum += $i;
                            //Send notification to supervisor(s)
                            $request_id = $requests->id;
                            $request_uri = Utilities::generateRequestId($request_id);
                            DB::table('requests')->where('id', $request_id)
                                ->update([
                                    'uri' => $request_uri
                                ]);
                            $item_name = Item::find($item_id)->name;
                            Utilities::notifySupervisorOfRequest($request_uri, $item_name);
                            //Send emails to notify supervisors
                            $name = Auth::user()->name;
                            $supers = User::where('role_id', 2)->get();
                            foreach ($supers as $super){
                                $email = $super->email;
                                $content = ['item' => $item_name, 'request_uri' => $request_uri];
                                Utilities::sendMailToNotifySupervisorOfRequests($email, $content);
                            }

                        }
                    }else{
                        //limit exceeded
                        $notification = array(
                            'notify' => 'Only '.$sum.' request (s) sent!'.' You have exceeded your limit! You can no longer add requests. Upgrade your plan.',
                            'alert-type' => 'error'
                        );
                        return back()->with($notification);
                    }

                }
                $notification = array(
                    'notify' => $sum.' request(s) successfully submitted!',
                    'alert-type' => 'success'
                );
                return redirect()->route('requests')->with($notification);
                //dd($array);
            }
        }else{
            return view('requests.new', compact('items', 'categories'));
        }
    }
}
