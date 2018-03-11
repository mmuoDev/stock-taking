<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\Utilities;
use Illuminate\Support\Facades\Auth;

class RestrictUsersPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::user()->id;
        $role_id = Utilities::getUserRole($user_id);
        if($role_id != 3){
            //Not allowed
            return response()->view('errors.403');
        }else{
            return $next($request);
        }

    }
}
