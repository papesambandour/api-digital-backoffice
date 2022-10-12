<?php

namespace App\Services\Partners\Metier;

use App\Models\OperationParteners;
use App\Models\SousServices;
use App\Models\Transactions;
use App\Services\Helpers\Utils;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class TransactionServices
{
    public function paginate()
    {
      //  dd(request('sous_services_id'));
        $transactions = Transactions::query()->orderBy('id','DESC')->where('parteners_id',_auth()['parteners_id']);
        if(request('statut')){
            $transactions->where(STATUS_TRX_NAME,request('statut'));
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
        if(request('search_in_any_id_transaction')){
            $transactions->where(function ($query)  {
                $query
                    ->where('external_transaction_id','like',"%".request('search_in_any_id_transaction') . "%")
                    ->orWhere('id','like',"%".request('search_in_any_id_transaction') . "%")
                    ->orWhere('transaction_id','like',"%".request('search_in_any_id_transaction') . "%")
                    ->orWhere('sous_service_transaction_id','like',"%".request('search_in_any_id_transaction') . "%")
                ;
            });
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
        if(isExportExcel()){
            $transactions->limit(exportMaxSize());
            die (exportExcel(mappingExportTransaction($transactions->get())));
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
