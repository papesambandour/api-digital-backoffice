<?php

namespace App\Services\Partners\Metier;

use App\Models\OperationParteners;
use App\Models\SousServices;
use App\Models\Transactions;
use App\Services\Helpers\Utils;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class UserManagemantServices
{
    public function paginateUsers(): LengthAwarePaginator
    {
        $query=  getUser()->users();

        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(request('q')){
            $query
                ->where(function ($query){
                    $query ->orWhere('email','like','%'.request('q').'%')
                        ->orWhere('phone','like','%'.request('q').'%')
                        ->orWhere('first_name','like','%'.request('q').'%');
                    return $query;
                })

                ->orWhere('last_name','like','%'.request('q').'%');
        }
        $query->orderBy('id','desc');
        return $query->paginate(size());
    }
    public function paginateRoles(): LengthAwarePaginator
    {
        $query=  getUser()->partnersRoles();
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(request('q')){
            $query->orWhere('name','like','%'.request('q').'%');
        }
        $query->orderBy('id','desc');
        return $query->paginate(size());
    }


}
