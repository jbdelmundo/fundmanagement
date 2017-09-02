<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\ModuleUser;

class ModulePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permit)
    {
		if(Auth::user()){
			$module_users = ModuleUser::where('module_id',(int)$permit)->where('user_id',Auth::user()->id)->get()->toArray();
		}
		else	$module_users = [];

		if(count($module_users)==0){
			return redirect('/dashboard');
		}
			
        return $next($request);
    }
}
