<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Services\Partners\Metier\ConfigServices;
use App\Services\Partners\Metier\TransactionServices;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;

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

    public function transaction()
    {
        $transactions = $this->transactions->paginate();
        $title = $this->title;
        $subTitle = $this->subTitle;
        $sous_services= $this->configServices->services();
        $sous_services_id= request('sous_services_id');
        $statut= request('statut');
        $date_start= request('date_start');
        $date_end= request('date_end');
        $search_in_any_id_transaction= request('search_in_any_id_transaction');
        $statuts = $this->transactions->status() ;
        $phone = request('phone');
        $amount_min = request('amount_min');
        $amount_max = request('amount_max');
        return view('partners/transaction.transaction',compact('amount_min','amount_max','phone','statuts','search_in_any_id_transaction','statut','sous_services_id','date_start','date_end','sous_services','transactions','title','subTitle'));
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
    public function retro(int $transactionID){
        /**
         * @var Transactions $transaction
         */
        $transaction = Transactions::find($transactionID);
        $sousServices= getSousServiceCashOut($transaction->sousService);
        return view('partners.transaction.retro',compact('transaction','sousServices'));
    }

    public static function getErrorMessage($responseData): string{
        //return json_encode($responseData);
        $message = '';
        try {
            $response = @$responseData->apiResponse;
            $firstKey = @array_keys((array)$response->data)[0];
            $message = @$response->data->$firstKey[0] ?? "";
        } catch (Exception $e) {
        }

        return @$response['message'].' '. $message;
    }


    public function retroSave(int $transactionId)
    {
        /**
         * @var Transactions $transaction
         */
        $transaction = Transactions::find($transactionId);
        if(retroTransaction($transaction)  ){
            $rest = Http::timeout(timeouts())->withHeaders([
                'apikey'=>env('SECRETE_API_DIGITAL')
            ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/retro',
                [
                    'transactionId'=>$transaction->id,
                    'codeService'=> request('codeService'),
                    'amount' => floatval(request('amount')),
                ]
            );
            $resBody = (array) $rest->object();
            if($rest->status() === 201 && @$resBody['statutTreatment'] === STATUS_TRX['SUCCESS']){
                return redirect("/partner/transaction")->with('success','La retro transaction  est effectif avec success. Message : '. @$resBody['message']);
            }else{
                return redirect('/partner/transaction')->with('error','Erreur lors de La retro transaction  est effectif. Message : '. TransactionsController::getErrorMessage($resBody));
            }
        }
        return  redirect('/partner/transaction')->with('error','La retro Transaction ne peut pas être effectué.');
    }

    public function reFund(string $transactionId)
    {
        /**
         * @var Transactions $transaction
         */
        $transaction = Transactions::query()
            ->where('id', (int)base64_decode($transactionId))
            ->where('parteners_id',_auth()['parteners_id'])->first();
        // return redirect()->back()->with('success','Transaction rembourser avec success');
        if($transaction && checkRefundable($transaction)   ){
            $rest = Http::withHeaders([
                'apikey'=>env('SECRETE_API_DIGITAL')
            ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/transaction/refund',
                ['transactionId'=>$transaction->id]
            );
            $resBody = (array) $rest->object();
            if($rest->status() === 201 && @$resBody['statutTreatment'] === STATUS_TRX['SUCCESS']){
                return redirect()->back()->with('success','Transaction rembourser avec success. Message : '. @$resBody['message']);
            }else{
                return redirect()->back()->with('error','Erreur lors du remboursement de la Transaction. Message : '. @$resBody['message']);
            }
        }
        return redirect()->back()->with('error','La transaction n\'est pas remboursable');

        //dump($rest->status());
        // dd($rest->body());
    }

}
