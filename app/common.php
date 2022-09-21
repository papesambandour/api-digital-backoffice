<?php

use App\Models\SousServices;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

#[ArrayShape(["first_name" => "string",  "parteners_id" => "string", "solde" => "string"])] function _auth(): array
{
    /**
     * @var \App\Models\Parteners $partner
    */
    //dd(getUser());
    $partner = \App\Models\Parteners::query()->find(getUser()['id']);
    return [
        "first_name" =>$partner->name,
        "parteners_id" =>$partner->id,
        "solde" =>$partner->solde,
    ];
}

function title(string $title): string
{
    return "INTECH API " . $title;
}

function dateFilterStart($date): DateTime
{
    return DateTime::createFromFormat('Y-m-d H:i:s', $date .' 00:00:00');
}
function dateFilterEnd($date): DateTime
{
    return DateTime::createFromFormat('Y-m-d H:i:s', $date .' 23:59:59');
}
function  page(): int{
    return (int)request('page',1);
}
function  size(): int
{
    return (int)request('size',15);
}
//'SUCCESS','PENDING','PROCESSING','FAILLED','CANCELED'
const STATUS = [
  'SUCCESS' => 'statut-success',
  'CANCELED' => 'table-warning',
  'FAILLED' => 'statut-danger',
  'PROCESSING' => 'statut-infos',
  'PENDING' => 'statut-infos',
];

const STATE = [
    'ACTIVED' => 'ACTIVED',
    'INACTIVED' => 'INACTIVED',
    'DELETED' => 'DELETED',
];
function status($status): string{
    return  @STATUS[$status] ?? '';
}

const OPERATIONS= [
    'APROVISIONNEMENT'=>'APROVISIONNEMENT'
];
const TYPE_PARTNER_COMPTE =[
    'API'=>'API',
    'CAISSE'=>'CAISSE'
];

function logoFromName($name): string{
    $tabNames = explode(' ',$name);
    $name  ='';
    foreach($tabNames as $tabName){
        $name .= ucfirst($tabName[0]);
    }
    return $name;
}
 function getAmountTransactionByServices(int $sousServicesId){
    return Transactions::where('sous_services_id',$sousServicesId)->whereBetween('created_at',[
        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
    ])->where(STATUS_TRX_NAME,'SUCCESS')->where('parteners_id',_auth()['parteners_id'])->sum('amount');
}
 function percentage($amount,int $sousServicesId): float|int
 {
    return  (($amount) / (Transactions::where('sous_services_id',$sousServicesId)
                    ->whereBetween('created_at',[
                        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
                        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
                    ])
                    ->where('parteners_id',_auth()['parteners_id'])->where(STATUS_TRX_NAME,'FAILLED')->sum('amount') + ($amount ?: 1) )) * 100;
}

 function amountState($status): float|int
 {
    return  Transactions::whereBetween('created_at',[
        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
    ])
                    ->where('parteners_id',_auth()['parteners_id'])->where(STATUS_TRX_NAME,$status)->sum('amount') ;
}
function loginUser(\App\Models\Parteners $partner):void{
    session([keyAuth() => $partner]);
}

/**
 * @throws ContainerExceptionInterface
 * @throws NotFoundExceptionInterface
 */
function getUser(){
  return  session()->get(keyAuth());
}
function keyAuth(): string
{
    return "__AUTH_PARTENER__";
}
function logOut(): void{
    session()->forget([keyAuth()]);
    session()->flush();
}

function checkAuth(): bool
{
    return session()->has(keyAuth());
}

  function GUID(): string
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
function nowIso(): string
{
    return gmdate("Y-m-d H:i:s");
}

function dateIso(DateTime $date,$format='Y-m-d' ): string
{
    return $date->format($format);
}
function money($number): string{
  return  number_format($number,'2','.',' ');
}
function percent($number): string{
  return  number_format($number,'2','.',' ');
}

function period(): string
{
    $start= request('date_start', gmdate('Y-m-d')  );
    $end= request('date_end', gmdate('Y-m-d'));
    if($start === $end && $end === gmdate('Y-m-d')){
        return  "Journée en cours";
    }
    return dateFr($start). ' - ' . dateFr($end);
}
function dateFr(string $date): string
{
    return implode('-',array_reverse(explode('-',$date)));
}
const STATUS_TRX_NAME = 'pre_statut';
//UPDATE transactions set pre_statut = statut;

const STATUS_CLAIM=[
    'CREATED'=>'CREATED',
    'OPENED'=>'OPENED',
    'CLOSED'=>'CLOSED'
];
const STATUS_CLAIM_LABEL=[
    'CREATED'=>'<label style="color: #324960;border: 2px dashed #324960;font-weight: bold;padding: 4px;border-radius: 10px;text-transform: uppercase">Crée </label>',
    'OPENED'=> '<label style="color: #236320;border: 2px dashed #236320;font-weight: bold;padding: 4px;border-radius: 10px;text-transform: uppercase">Ouvert</label>',
    'CLOSED'=> '<label style="color: #ba6a35;border: 2px dashed #ba6a35;font-weight: bold;padding: 4px;border-radius: 10px;text-transform: uppercase">Fermer</label>'
];
const STATUS_CLAIM_LABEL_TEXT=[
    'CREATED'=>'Crée',
    'OPENED'=> 'Ouvert',
    'CLOSED'=> 'Ferme'
];
function claimStatut($status){
    return @STATUS_CLAIM_LABEL[$status] ?: $status;
}
function claimStatutText($status){
    return @STATUS_CLAIM_LABEL_TEXT[$status] ?: $status;
}
 function notificationTicket($message,$canal,$even,$isCritic= false): bool
{

    $rest = Http::withHeaders([
        'apikey'=>env('SECRETE_API_DIGITAL')
    ])->post(env('API_DIGITAL_URL') . '/api/v1.0/partner/notification/send',
        ["channel"=> $canal, "message" => $message, "event"=> $even , "isCritic"=>$isCritic]
    );
    if($rest->status() === 201){
        return true;
    }else{
        return false;
    }
}
const TYPE_SERVICES = [
    'CASHOUT'=>'CASHOUT',
    'CASHIN'=>'CASHIN',
];
const STATUS_TRX=[
    'SUCCESS'=>'SUCCESS','PENDING'=>'PENDING','PROCESSING'=>'PROCESSING','FAILLED'=>'FAILLED','CANCELED'=>'CANCELED'
];
function retroTransaction(Transactions $transaction): bool
{
    return
        ($transaction->statut == STATUS_TRX['SUCCESS'])
        && $transaction->sousService->typeService->code === TYPE_SERVICES['CASHIN'];
}

function getSousServiceCashOut(SousServices $sousServices): Collection|array
{
    return SousServices::query()
        ->whereHas('typeService',function ($query) use ($sousServices){
            $query->where('code', TYPE_SERVICES['CASHIN']);
        })->whereHas('service',function ($query) use ($sousServices){
            $query->whereHas('operator',function ($query2) use ($sousServices){
                $query2->where('countries_id',$sousServices->service->operator->countries_id);
            });
        })->get();
}
const TYPE_OPERATION =[
    'DEBIT'=>'DEBIT',
    'CREDIT'=>'CREDIT'
];
function checkRefundable(Transactions $transaction): bool
{
    return $transaction->statut == STATUS_TRX['SUCCESS']
        && $transaction->type_operation === TYPE_OPERATION['DEBIT']
        && $transaction->sousService->typeService->code === TYPE_SERVICES['CASHOUT'];
}
