<?php

namespace App\Http\Controllers;

use App\Category;
use App\Libraries\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function  __construct()
    {
        return $this->middleware('auth');
    }
    public function index(){
        $company_id = Auth::user()->company_id;
        $categories = Category::orderBy('created_at', 'DESC')->where('company_id', $company_id)->get();
        return view('settings.category.index', compact('categories'));
    }
    public function create(Request $request){
        $method = $request->isMethod('post');
        if($method){ //Process form
            $category_limit = Utilities::getCategoryLimit();
            $category_count = Utilities::currentCategoryCount();
            if($category_count < $category_limit) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|unique:categories'
                ]);
                if ($validator->fails()) {
                    return back()->withErrors($validator);
                }
                $category = Category::create(
                    [
                        'name' => $request->name,
                        'created_by' => Auth::user()->id,
                        'company_id' => Auth::user()->company_id
                    ]
                );
                if ($category) {
                    $notification = array(
                        'notify' => 'New category added!',
                        'alert-type' => 'success'
                    );
                    return back()->with($notification);
                } else {
                    //return back()->withErrors("Ooops! Something just happen!");
                    $notification = array(
                        'notify' => 'Ooops! Something went wrong!',
                        'alert-type' => 'error'
                    );
                    return back()->with($notification);
                }
            }else{
                $notification = array(
                    'notify' => 'You have exceeded your limit! You can no longer add categories. Upgrade your plan.',
                    'alert-type' => 'error'
                );
                return back()->with($notification);
            }

        }else{ //Display form
            $company_id = Auth::user()->company_id;
            $categories = Category::orderBy('created_at', 'DESC')->where('company_id', $company_id)->get();
            return view('settings.category.index', compact('categories'));
        }
    }
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        //dd($request->all());
        $update = DB::table('categories')
            ->where('id', $request->category_id)
            ->update([
                'name' => $request->name
            ]);
        //dd($update);
        if($update){
            $notification = array(
                'notify' => 'Category updated!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'notify' => 'Ooops! Something went wrong!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

    }
}
