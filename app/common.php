<?php

use App\Models\Transactions;
use JetBrains\PhpStorm\ArrayShape;

#[ArrayShape(["first_name" => "string", "last_name" => "string", "parteners_id" => "string", "solde" => "string"])] function _auth(): array
{
    return [
        "first_name" =>"Pape Sammba",
        "last_name" =>"NDOUR",
        "parteners_id" =>1,
        "solde" =>"20990.90",
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
    return (int)request('size',10);
}
//'SUCCESS','PENDING','PROCESSING','FAILLED','CANCELED'
const STATUS = [
  'SUCCESS' => 'statut-success',
  'CANCELED' => 'table-warning',
  'FAILLED' => 'statut-danger',
  'PROCESSING' => 'statut-infos',
  'PENDING' => 'statut-infos',
];
function status($status): string{
    return  @STATUS[$status] ?? '';
}

const OPERATIONS= [
    'APROVISIONNEMENT'=>'APROVISIONNEMENT'
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
    return Transactions::where('sous_services_id',$sousServicesId)->whereIn('created_at',[dateFilterStart(gmdate('Y-m-d')),dateFilterEnd(gmdate('Y-m-d'))])->where('statut','SUCCESS')->sum('amount');
}
 function percentage($amount,int $sousServicesId): float|int
 {
    return  (($amount ?: 1) / (Transactions::where('sous_services_id',$sousServicesId)
                    ->whereIn('created_at',[dateFilterStart(gmdate('Y-m-d')),dateFilterEnd(gmdate('Y-m-d'))])
                    ->where('parteners_id',_auth()['parteners_id'])->where('statut','FAILLED')->sum('amount') + ($amount ?: 1) )) * 100;
}

 function amountState($status): float|int
 {
    return  Transactions::whereIn('created_at',[dateFilterStart(gmdate('Y-m-d')),dateFilterEnd(gmdate('Y-m-d'))])
                    ->where('parteners_id',_auth()['parteners_id'])->where('statut',$status)->sum('amount') ;
}
function loginUser(\App\Models\Parteners $partner):void{
    session([keyAuth() => $partner]);
}
function keyAuth(): string
{
    return "__AUTH_PARTENER__";
}
function logOut(): void{
    session()->forget([keyAuth()]);
    session()->flush();
}
