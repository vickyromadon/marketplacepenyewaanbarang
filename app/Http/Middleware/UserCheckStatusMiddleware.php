<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserCheckStatusMiddleware
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
        if( Auth::user()->privilege == 0 ){
            if( Auth::user()->status == "not active" ){
                return redirect()->route('member.user.not_active');
            }
            else if( Auth::user()->status == User::STATUS_UNCONFIRM ){
                return redirect()->route('member.user.unconfirm');
            }
        }
        else{
            if( Auth::user()->status == "not active" ){
                return redirect()->route('owner.user.not_active');
            }
            else if( Auth::user()->status == User::STATUS_UNCONFIRM ){
                return redirect()->route('owner.user.unconfirm');
            }   
        }
        return $next($request);
    }
}
