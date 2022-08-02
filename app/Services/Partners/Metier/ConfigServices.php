<?php

namespace App\Services\Partners\Metier;

use App\Models\PartenerComptes;
use App\Models\SousServices;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ConfigServices
{
    public function services(){
        return SousServices::whereHas('sousServicesParteners',fn($query)=> $query->where('parteners_id',_auth()['parteners_id']))->get();
    }
    public function servicesLimit5(){
        return SousServices::whereHas('sousServicesParteners',fn($query)=> $query->where('parteners_id',_auth()['parteners_id']))
//            ->whereHas('transactions',fn($query)=> $query->orderBy(DB::raw("sum('amount') ")))
            ->limit(5)->get();
    }

    public function servicesPaginate(){
        $query = SousServices::whereHas('sousServicesParteners',fn($query)=> $query->where('parteners_id',_auth()['parteners_id']));
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        return $query->orderBy('id','DESC')->paginate(size());
    }
    public function apikeyPaginate(): LengthAwarePaginator
    {
        $query = PartenerComptes::query()->where('parteners_id',_auth()['parteners_id']);
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        return $query->orderBy('id','DESC')->paginate(size());
    }
    public function addKey(){
        $key  = PartenerComptes::query()->where('parteners_id',_auth()['parteners_id'])->count();
       return PartenerComptes::create([
            'type_partener_compte' => TYPE_PARTNER_COMPTE['API'],
            'parteners_id' => _auth()['parteners_id'],
            'created_at' => nowIso(),
            'state' => STATE['ACTIVED'],
            'name' => _auth()['first_name'] . ' API KEY ' . (++$key) ,
            'app_key' => GUID(),
        ]);
    }
    public function regenerateKey($idKey): PartenerComptes
    {
        /**
         * @var PartenerComptes $partenerComptes
        */
        $partenerComptes  = PartenerComptes::query()->where('parteners_id',_auth()['parteners_id'])->where('id',$idKey)->first();
        $partenerComptes->app_key = GUID();
        $partenerComptes->save();
        return $partenerComptes;
    }

}
