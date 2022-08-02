<?php

use App\Models\Transactions;
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
    ])->where('statut','SUCCESS')->sum('amount');
}
 function percentage($amount,int $sousServicesId): float|int
 {
    return  (($amount) / (Transactions::where('sous_services_id',$sousServicesId)
                    ->whereBetween('created_at',[
                        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
                        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
                    ])
                    ->where('parteners_id',_auth()['parteners_id'])->where('statut','FAILLED')->sum('amount') + ($amount ?: 1) )) * 100;
}

 function amountState($status): float|int
 {
    return  Transactions::whereBetween('created_at',[
        dateFilterStart(request('date_start',gmdate('Y-m-d'))),
        dateFilterEnd(request('date_end',gmdate('Y-m-d')))
    ])
                    ->where('parteners_id',_auth()['parteners_id'])->where('statut',$status)->sum('amount') ;
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
