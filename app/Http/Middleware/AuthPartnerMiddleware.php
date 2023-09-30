<?php

namespace App\Http\Middleware;

use App\Models\Authorization\PartnersActions;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthPartnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    {
        if(checkAuth()){
            /**
             * @var $route Route
             */
            $route= Route::getCurrentRoute();
            $actionCode= @$route->action['as'];
            $actionCode = @explode(':',$actionCode)[0];
            $actionExist= action_exist($actionCode);
           if($actionExist){
               if(has($actionCode)){
                   return $next($request);
               }else{
                   return  redirect('/partner/home')->with('error',"Vous ne pouvez pas accéder a cette ressource. Contacter notre administrateur pour lui faire une demande attribution de ce droit d'action");
               }
           }else{
               return $next($request);
           }

        }else{
            return redirect('/auth-partner/login');
        }

    }
}
