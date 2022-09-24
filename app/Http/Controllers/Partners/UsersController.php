<?php

namespace App\Http\Controllers\Partners;

use App\Services\UserServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UsersController
{
    private UserServices $userServices;

    /**
     * @param UserServices $userServices
     */
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function profil(Request $request): Factory|View|Application
    {
        $user = user();
        return view('partners.profil',compact('user'));
    }
    public function account(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->userServices->account($request);
    }
    public function password(Request $request): Redirector|Application|\Illuminate\Http\RedirectResponse
    {
        return $this->userServices->password($request);
    }

}
