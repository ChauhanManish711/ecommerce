<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class CheckUserAlreadyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::Check()){
            $user_id = Auth::User()->roles()->first()->id;
            if($user_id == '6')
            {
                return redirect()->route('home');
            }
            elseif($user_id <= '5')
            {
                return redirect()->route('dashboard');
            }   
            else{
                Auth::logout();
            }
        }
        return $next($request);
    }
}
