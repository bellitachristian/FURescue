<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash; 
use App\Models\Usertype;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $admin = Admin::first();
        $username = 'admin@gmail.com';
        $pass ='adminadmin';
        
        if(is_null($admin)){
            $usertype = new Usertype;
            $usertype ->usertype ="Admin";
            $usertype ->save();

            $admin = new Admin;
            $admin->email = $username;
            $admin->password =  Hash::make($pass);
            $admin->usertype_id = $usertype->id;
            $admin->save();  
        }
        return $next($request);
    }
}
