<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Authorization\PartnersActions;
use App\Models\Authorization\PartnersActionsRoles;
use App\Models\Authorization\PartnersRoles;
use App\Services\Partners\Metier\UserManagemantServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $partnersActions= PartnersActions::all();
        return view('partners.role.add',compact('role','partnersActions'));
    }

    /**
     */
    public function edit(Request $request,PartnersRoles $role): Factory|View|Application
    {
        $partnersActions= PartnersActions::all();
        return view('partners.role.add',compact('role','partnersActions'));
    }
    function getRules($id=null): array
    {
        return [
            'name'=>'required|string|min:4' ,
            'actions'=>'required|array' ,
        ];
    }

    public function store(Request $request)
    {
        $role= $this->validate($request,$this->getRules());
        $role['parteners_id']=getUser()->id;
        $role['code']= getCodeRole($role['name']);
        $roleDb = PartnersRoles::create($role);
        $this->syncAction($roleDb,$role['actions']);
        return redirect("/partner/role")->with('success','Role ajouter avec sucés');
    }
    function syncAction(PartnersRoles $role,array $actions): void
    {
        DB::beginTransaction();
        $role->partnersActionsRoles()->delete();
        collect($actions)
            ->map(function ($action) use ($role) {
                PartnersActionsRoles::create([
                    'parteners_roles_id'=>$role->id,
                    'parteners_actions_id'=>$action,
                    'parteners_id'=>getUser()->id,
                ]);
            });
        DB::commit();
    }
    public function update(Request $request,$id)
    {
        $roleDb = PartnersRoles::findOrFail($id);
        $role= $this->validate($request,$this->getRules($id));
       //dd($request->all());
        $roleDb->update($role);
        $this->syncAction($roleDb,$role['actions']);
        return redirect("/partner/role")->with('success','Role mise à jour avec sucés');
    }

}
