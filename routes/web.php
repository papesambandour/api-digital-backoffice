<?php

use App\Http\Controllers\Partners\AuthPartnersController;
use App\Http\Controllers\Partners\ClaimController;
use App\Http\Controllers\Partners\ConfigurationController;
use App\Http\Controllers\Partners\DashboardController;
use App\Http\Controllers\Partners\RolePartnerController;
use App\Http\Controllers\Partners\TransactionsController;
use App\Http\Controllers\Partners\UsersController;
use App\Http\Controllers\Partners\UsersPartnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$proxy_url    = getenv('PROXY_URL');
$proxy_schema = getenv('PROXY_SCHEMA');

if (!empty($proxy_url)) {
    URL::forceRootUrl($proxy_url);
}

if (!empty($proxy_schema)) {
    URL::forceScheme($proxy_schema);
}

Route::get('/', function () {
    return redirect('/partner');
});

Route::group(['middleware'=>[],'prefix'=>'auth-partner'],function(){
    Route::get('/login',[AuthPartnersController::class,'login'] );
    Route::post('/login',[AuthPartnersController::class,'loginPost'] );
    Route::get('/logout',[AuthPartnersController::class,'logOut'] );
});


Route::group(['middleware'=>['partner-auth'],'prefix'=>'partner'],function(){
    /*REPORTING START*/
    Route::get('/home',[DashboardController::class,'home'] );
    Route::get('/',[DashboardController::class,'dashboard'] )->name(action_dashboard());
   // Route::get('/statistic',[DashboardController::class,'statistic'] );
    /*REPORTING START*/

    /*TRANSACTION START*/
    Route::get('/transaction/retro/{transaction}',[TransactionsController::class,'retro'] )->name(action_retro_trx().':create');
    Route::post('/transaction/retro/{transaction}',[TransactionsController::class,'retroSave'] )->name(action_retro_trx());
    Route::get('/transaction/reFund/{transaction}',[TransactionsController::class,'reFund'] )->name(action_refund());
    Route::get('/transaction',[TransactionsController::class,'transaction'] )->name(action_transaction());
    Route::get('/versement',[TransactionsController::class,'versement'] )->name(action_versement());
    Route::get('/mvm-compte',[TransactionsController::class,'mvmCompte'] )->name(action_mvm_compte());
    /*TRANSACTION END*/

    /*CONFIGURATIONS START*/
    Route::get('/service',[ConfigurationController::class,'service'] )->name(action_service());
    Route::get('/apikey',[ConfigurationController::class,'apikey'] )->name(action_apikey());
    Route::post('/apikey/addkey',[ConfigurationController::class,'addKey'] )->name(action_apikey().':add');
    Route::post('/apikey/regenerateKey/{idKey}',[ConfigurationController::class,'regenerateKey'] )->name(action_apikey().':regenerate');
    Route::post('/apikey/revoqKey/{idKey}',[ConfigurationController::class,'revoqKey'] )->name(action_apikey().':revoq');
    Route::post('/apikey/raname/{idKey}',[ConfigurationController::class,'ranameKey'] )->name(action_apikey().':ranameKey');;
   // Route::get('/reclamation',[ConfigurationController::class,'reclamation'] )->name(action_claim());
    /*CONFIGURATIONS END*/

    /*CLAIM START*/
    Route::resource('/claim', ClaimController::class,[
        'names'=>['index'=>action_claim(),'store'=>action_claim().':add','create'=>action_claim().':create','delete'=>action_claim().':delete','update'=>action_claim().':update','edit'=>action_claim().':edit','show'=>action_claim().':show']
    ])->only(['index','store','create','delete','update','edit','show']);
    /*CLAIM END*/

    Route::get('/profil', [UsersController::class,'profil']);
    Route::post('/account', [UsersController::class,'account']);
    Route::post('/password', [UsersController::class,'password']);


    /*USER START*/
    Route::resource('/user', UsersPartnerController::class,[
        'names'=>['index'=>action_user(),'store'=>action_user().':add','create'=>action_user().':create','delete'=>action_user().':delete','update'=>action_user().':update','edit'=>action_user().':edit','show'=>action_user().':show']
    ])->only(['index','store','create','delete','update','edit','show']);
    /*USER END*/

    /*USER START*/
    Route::resource('/role', RolePartnerController::class,
    [
        'names'=>['index'=>action_role(),'store'=>action_role().':add','create'=>action_role().':create','delete'=>action_role().':delete','update'=>action_role().':update','edit'=>action_role().':edit','show'=>action_role().':show']
    ])->only(['index','store','create','delete','update','edit','show']);
    /*USER END*/
});
