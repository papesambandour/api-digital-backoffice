<?php

use App\Models\Country;
use App\Models\SousServices;
use App\Models\Transactions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
function user(){
    return \App\Models\Parteners::query()->find(getUser()['id']);
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
    return (int)request('size',30);
}


function  timeouts(): int
{
    return 60;
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
        && $transaction->sousService->typeService->code === TYPE_SERVICES['CASHOUT'];
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
      /*  && $transaction->type_operation === TYPE_OPERATION['CREDIT']
        && $transaction->sousService->typeService->code === TYPE_SERVICES['CASHOUT']*/
        ;
}
function countries(): Collection
{
    return Country::all();
}

function exportExcel(array $data ){
    try {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /*SET CONTENT*/
        $y=1;
        $alfa = range('A','Z');
        foreach ($data as $value){
            $x = 0 ;
            foreach ($value as $key =>$va){
                $sheet->setCellValue(@$alfa[$x] . $y, ucfirst($key));
                $sheet->getColumnDimension(@$alfa[$x])->setAutoSize(true);
                $x++;
            }

            $y++ ;
            break;
        }
        foreach ($data as $value){
            $x = 0 ;
            foreach ($value as $key =>$va){
                $sheet->setCellValue(@$alfa[$x] . $y,$va);
                $sheet->getColumnDimension(@$alfa[$x])->setAutoSize(true);
                $x++;
            }
            $y++ ;
        }
        $sheet->getStyle('A:Z')->getAlignment()->setHorizontal('left');

        //  $sheet->setCellValue('A1', 'Hello World !');
        /*SET CONTENT*/
        $path = tempnam(sys_get_temp_dir(), '_intech_api_');
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);
        $res = file_get_contents($path);
        $b64Doc = base64_encode(($res ?: ''));// file
        unlink($path);
        return json_encode(['data'=>"data:application/xlsx;base64," . $b64Doc,'msg'=>'exportation ok','error'=>false,'code'=>200]) ;
    } catch (Exception $e) {
        die($e->getMessage());
    }
}
/**
 * @param Collection $transactions
 * @return array
 */
function mappingExportTransaction(Collection $transactions): array
{
    return $transactions->map(function(Transactions $transaction){
        return [
            'ID'=> $transaction->id,
            'Transaction Id'=> $transaction->transaction_id,
            'Partnaire Id'=> $transaction->external_transaction_id,
            'Numéro'=> $transaction->phone.''.$transaction->rib,
            'Montant'=> $transaction->amount  ,
            'Type Operation'=> $transaction->type_operation  ,
            'Partenaire'=> $transaction->partener_name  ,
            'Commission'=> $transaction->commission_amount ,
            'Frais'=> $transaction->fee_amount  ,
            'Services'=> $transaction->sous_service_name  ,
           // 'Sous Services'=> $transaction->service_name  ,
            'Statut'=>  $transaction->{STATUS_TRX_NAME},
            'Date de creation'=> $transaction->created_at->format('Y-m-d'),
        ];
    })->toArray();
}


function  exportMaxSize(): int
{
    return (int)50000;
}

function isExportExcel(): bool
{
    return !!request('_exported_excel_',false);
}
