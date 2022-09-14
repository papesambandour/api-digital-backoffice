<?php

namespace App\Http\Controllers\Partners;

use App\Models\Claim;
use App\Models\Parteners;
use App\Models\Transactions;
use App\Services\Helpers\Utils;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ClaimController
{
    public function index(): Factory|View|Application
    {
        $claims = Claim::query();
        $date_start= request('date_start');
        if($date_start){
            $claims->where('created_at','>=',$date_start);
        }
        $date_end= request('date_end');
        if($date_end){
            $claims->where('updated_at','<=',$date_end);
        }
        $ref= request('ref');
        if($ref){
            $claims->where('claim_ref','like',"%$ref%");
        }
        $transactionId= request('transactionId');

        if($transactionId){
            $claims->where('transaction_id',$transactionId);
        }
        $claims = $claims->paginate(size());
        return view('partners.claim.index',compact('date_end','date_start','claims','ref','transactionId'));
    }
    public function show(Claim $claim): Factory|View|Application
    {
        return view('partners.claim.show',compact('claim'));
    }
    public function create()
    {
        $transaction_id= base64_decode(request('trx'));
        $claim = Claim::query()->where('transaction_id',$transaction_id)->first();
        if($claim){
            return  redirect("/partner/claim/$claim->id");
        }
        return view('partners.claim.add',compact('transaction_id'));
    }
    public function store(Request $request)
    {
       $data =  $request->validate([
            'message' =>'required|min:10',
            'subject' =>'required|min:5',
            'transaction_id' =>'required|exists:transactions,id'
        ]);
       $trx= Transactions::query()->where('id',$data['transaction_id'])->where('parteners_id',_auth()['parteners_id'])->first();
       if(!$trx){
         return  redirect()->back()->with('error', 'transaction introuvable');
       }
       $claim = Claim::query()->where('transaction_id',$trx->id)->first();
        if($claim){
            return  redirect("/partner/claim/$claim->id");
        }
       $lastClaim = (int)optional(Claim::query()->orderByDesc('id')->first())->id + 1;
       $length= strlen($lastClaim .'') + 2 ;
       if($length < 5){
           $length= 5;
       }
       $lastClaim= str_pad($lastClaim,$length,'0',STR_PAD_LEFT);
       $lastClaim = "P" . _auth()['parteners_id'] . "-" . $lastClaim;
        Claim::create([
            'message' =>$data['message'],
            'subject' =>$data['subject'],
            'transaction_id' =>$data['transaction_id'],
            'claim_ref'=>$lastClaim,
            'parteners_id'=>_auth()['parteners_id'],
        ]);
        return redirect('/partner/claim')->with('success','Réclamation ajouter avec succès');
    }

}