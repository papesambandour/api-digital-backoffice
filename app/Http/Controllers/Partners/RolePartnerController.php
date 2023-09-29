<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Authorization\PartnersRoles;
use App\Services\Partners\Metier\UserManagemantServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class RolePartnerController extends Controller
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
        $roles =  $this->services->paginateRoles();
        $date_start= request('date_start');
        $date_end= request('date_end');
        $q= request('q');
        return view('partners.role.index',compact('roles','date_end','q','date_start'));
    }

    /**
     */
    public function create(Request $request,PartnersRoles $role=null): Factory|View|Application
    {
        return view('partners.role.add',compact('role'));
    }

    /**
     */
    public function edit(Request $request,PartnersRoles $role): Factory|View|Application
    {
        return view('partners.role.add',compact('role'));
    }
    function getRules($id=null): array
    {
        return [
            'name'=>'required|string|min:4' ,
        ];
    }

    public function store(Request $request)
    {
        $role= $this->validate($request,$this->getRules());
        $role['parteners_id']=getUser()->id;
        $role['code']= getCodeRole($role['name']);
        PartnersRoles::create($role);
        return redirect("/partner/role")->with('success','Role ajouter avec sucés');
    }
    public function update(Request $request,$id)
    {
        $roleDb = PartnersRoles::findOrFail($id);
        $role= $this->validate($request,$this->getRules($id));
        $roleDb->update($role);
        return redirect("/partner/role")->with('success','Role mise à jour avec sucés');
    }

}
