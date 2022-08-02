<?php

namespace App\Services\Partners\Metier;

use App\Models\OperationParteners;
use App\Models\SousServices;
use App\Models\Transactions;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionServices
{
    public function paginate(): LengthAwarePaginator
    {
      //  dd(request('sous_services_id'));
        $transactions = Transactions::query()->orderBy('id','DESC')->where('parteners_id',_auth()['parteners_id']);
        if(request('statut')){
            $transactions->where('statut',request('statut'));
        }
        if(request('date_start')){
            $transactions->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $transactions->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        if(request('sous_services_id')){
            $transactions->where('sous_services_id','=',request('sous_services_id'));
        }
        if(request('external_transaction_id')){
            $transactions->where('external_transaction_id','like',"%".request('external_transaction_id') . "%");
        }
        if(request('phone')){
            $transactions->where('phone','like',"%".request('phone')."%");
        }
        if(request('amount_max')){
            $transactions->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $transactions->where('amount','>=',request('amount_min'));
        }

        return $transactions->paginate(size());
    }


    public function status(): array
    {
        return array_keys(STATUS);
    }
    public function versementPaginate(): LengthAwarePaginator
    {
       $query =  OperationParteners::query()->where('parteners_id',_auth()['parteners_id'])->where('operation',OPERATIONS['APROVISIONNEMENT']);
        if(request('amount_max')){
            $query->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('amount','>=',request('amount_min'));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
       return  $query->orderBy('id','DESC')->paginate(size());
    }

    public function mouvements(): LengthAwarePaginator
    {
        $query =  OperationParteners::query()->where('parteners_id',_auth()['parteners_id']);
        if(request('amount_max')){
            $query->where('amount','<=',request('amount_max'));
        }
        if(request('amount_min')){
            $query->where('amount','>=',request('amount_min'));
        }
        if(request('date_start')){
            $query->where('created_at','>=',dateFilterStart(request('date_start')));
        }
        if(request('date_end')){
            $query->where('created_at','<=',dateFilterEnd(request('date_end')));
        }
        return  $query->orderBy('id','DESC')->paginate(size());
    }

}
