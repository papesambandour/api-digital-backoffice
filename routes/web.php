<?php

use App\Http\Controllers\Partners\AuthPartnersController;
use App\Http\Controllers\Partners\ClaimController;
use App\Http\Controllers\Partners\ConfigurationController;
use App\Http\Controllers\Partners\DashboardController;
use App\Http\Controllers\Partners\TransactionsController;
use App\Http\Controllers\Partners\UsersController;
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
    Route::get('/',[DashboardController::class,'dashboard'] );
    Route::get('/statistic',[DashboardController::class,'statistic'] );
    /*REPORTING START*/

    /*TRANSACTION START*/
    Route::get('/transaction/retro/{transaction}',[TransactionsController::class,'retro'] );
    Route::post('/transaction/retro/{transaction}',[TransactionsController::class,'retroSave'] );
    Route::get('/transaction/reFund/{transaction}',[TransactionsController::class,'reFund'] );
    Route::get('/transaction',[TransactionsController::class,'transaction'] );
    Route::get('/versement',[TransactionsController::class,'versement'] );
    Route::get('/mvm-compte',[TransactionsController::class,'mvmCompte'] );
    /*TRANSACTION END*/

    /*CONFIGURATIONS START*/
    Route::get('/service',[ConfigurationController::class,'service'] );
    Route::get('/apikey',[ConfigurationController::class,'apikey'] );
    Route::post('/apikey/addkey',[ConfigurationController::class,'addKey'] );
    Route::post('/apikey/regenerateKey/{idKey}',[ConfigurationController::class,'regenerateKey'] );
    Route::post('/apikey/revoqKey/{idKey}',[ConfigurationController::class,'revoqKey'] );
    Route::post('/apikey/raname/{idKey}',[ConfigurationController::class,'ranameKey'] );
    Route::get('/reclamation',[ConfigurationController::class,'reclamation'] );
    /*CONFIGURATIONS END*/

    /*CLAIM START*/
    Route::resource('/claim', ClaimController::class)->only(['index','store','create','delete','update','edit','show']);
    /*CLAIM END*/

    Route::get('/profil', [UsersController::class,'profil']);
    Route::post('/account', [UsersController::class,'account']);
    Route::post('/password', [UsersController::class,'password']);
});
