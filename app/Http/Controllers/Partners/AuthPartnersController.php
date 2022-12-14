<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Services\Partners\Security\LoginPartnerServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;

class AuthPartnersController extends Controller
{
    public LoginPartnerServices $loginPartnerServices;

    /**
     * @param LoginPartnerServices $loginPartnerServices
     */
    public function __construct(LoginPartnerServices $loginPartnerServices)
    {
        $this->loginPartnerServices = $loginPartnerServices;
    }

    public function login(): Factory|View|Application
    {
        return view('partners/security/login');
    }
    public function loginPost()
    {
       $credentials = request(['email','password']);

       $login = $this->loginPartnerServices->login($credentials['email'],$credentials['password']);
       if($login){
           return redirect('partner');
       }else{
           //Redirect::back()->withErrors(['msg' => 'The Message']);
           return redirect()->back()->with('error','Login ou mot de passe incorrect');
       }
    }
    public function logOut(){
        logOut();
       return redirect("/auth-partner/login");
    }
}
