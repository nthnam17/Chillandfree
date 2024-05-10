<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
       
        $url = '/' . Request::path();
        $permission = Permission::where('slug', $url)->first();

        if (!$permission || !Auth::user()->hasPermissionTo($permission->name)) {

            if($request->ajax()) {
                
                return response_json(401, "Không có quyền!", "danger");
            }else {
                // abort(401);
                return redirect('/');
            }
        } else {
            return $next($request);
        }


        return $next($request);
    }
}
