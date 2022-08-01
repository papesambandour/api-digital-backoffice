<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Services\Partners\Metier\ConfigServices;
use App\Services\Partners\Metier\TransactionServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TransactionsController extends Controller
{
    public string $title = 'Transactions';
    public string $subTitle = 'Donne la listes des transactions des differentes services';
    private TransactionServices $transactions;
    private ConfigServices $configServices;

    /**
     * @param TransactionServices $transactions
     */
    public function __construct(TransactionServices $transactions,ConfigServices $configServices)
    {
        $this->transactions = $transactions;
        $this->configServices = $configServices;
    }

    public function transaction(): Factory|View|Application
    {
        $transactions = $this->transactions->paginate();
        $title = $this->title;
        $subTitle = $this->subTitle;
        $sous_services= $this->configServices->services();
        $sous_services_id= request('sous_services_id');
        $statut= request('statut');
        $date_start= request('date_start');
        $date_end= request('date_end');
        $external_transaction_id= request('external_transaction_id');
        $statuts = $this->transactions->status() ;
        $phone = request('phone');
        $amount_min = request('amount_min');
        $amount_max = request('amount_max');
        return view('partners/transaction.transaction',compact('amount_min','amount_max','phone','statuts','external_transaction_id','statut','sous_services_id','date_start','date_end','sous_services','transactions','title','subTitle'));
    }
    public function versement(): Factory|View|Application
    {
        $versements = $this->transactions->versementPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        $amount_min = request('amount_min');
        $amount_max = request('amount_max');
        return view('partners/transaction.versement',compact('versements','amount_min','amount_max','date_end','date_start',));
    }
    public function mvmCompte(): Factory|View|Application
    {
        $mouvements = $this->transactions->mouvements();
        $date_start= request('date_start');
        $date_end= request('date_end');
        $amount_min = request('amount_min');
        $amount_max = request('amount_max');
        return view('partners/transaction.mvm-compte',compact('mouvements','amount_min','amount_max','date_end','date_start',));
    }

}
