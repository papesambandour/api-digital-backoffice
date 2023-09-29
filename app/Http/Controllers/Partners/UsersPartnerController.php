<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Authorization\PartnersUsers;
use App\Services\Partners\Metier\UserManagemantServices;
use App\Services\UserServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class UsersPartnerController extends Controller
{
   public UserManagemantServices $services;

    /**
     * @param UserManagemantServices $services
     */
    public function __construct(UserManagemantServices $services)
    {
        $this->services = $services;
    }

    /**
     */
    public function index(Request $request): Factory|View|Application
    {
        $users =  $this->services->paginateUsers();
        $date_start= request('date_start');
        $date_end= request('date_end');
        $q= request('q');
        return view('partners.user.index',compact('users','date_end','q','date_start'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function create(Request $request,PartnersUsers $user = null): Factory|View|Application
    {
        $roles = getUser()->partnersRoles()->paginate(10);
        return view('partners.user.add',compact('roles','user'));
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function edit(Request $request,PartnersUsers $user): Factory|View|Application
    {
        $roles = getUser()->partnersRoles()->paginate(10);
        return view('partners.user.add',compact('roles','user'));
    }
    function getRules($id=null): array
    {
        return [
            'email'=>'required|email|unique:parteners_users,email' . ($id ? ','.$id : '') . '|unique:parteners,email' ,
            'phone'=>'required|regex:/^\+?\d{9,16}$/|unique:parteners_users,phone' . ($id ? ','.$id : ''),
            'first_name'=>'required|string|min:2',
            'last_name'=>'required|string|min:2',
            'parteners_roles_id'=>'required|exists:parteners_roles,id',
        ];
    }

    public function store(Request $request)
    {
        $user= $this->validate($request,$this->getRules());
        $user['parteners_id']=getUser()->id;
        PartnersUsers::create($user);
        return redirect("/partner/user")->with('success','Utilisateur ajouter avec sucés');
    }
    public function update(Request $request,$id)
    {
        $userDb = PartnersUsers::findOrFail($id);
        $user= $this->validate($request,$this->getRules($id));
        $userDb->update($user);
        return redirect("/partner/user")->with('success','Utilisateur mise à jour avec sucés');
    }

}
