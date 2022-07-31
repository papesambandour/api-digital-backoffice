<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class TransactionsController extends Controller
{
    public function transaction(): Factory|View|Application
    {
        return view('partners/transaction.transaction');
    }
    public function versement(): Factory|View|Application
    {
        return view('partners/transaction.versement');
    }
    public function mvmCompte(): Factory|View|Application
    {
        return view('partners/transaction.mvm-compte');
    }

}
