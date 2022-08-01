<?php

use App\Http\Controllers\Partners\AuthPartnersController;
use App\Http\Controllers\Partners\ConfigurationController;
use App\Http\Controllers\Partners\DashboardController;
use App\Http\Controllers\Partners\TransactionsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
   dd('DTYB7FDGNHHFT', \Illuminate\Support\Facades\Hash::make('DTYB7FDGNHHFT'));
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
    Route::get('/transaction',[TransactionsController::class,'transaction'] );
    Route::get('/versement',[TransactionsController::class,'versement'] );
    Route::get('/mvm-compte',[TransactionsController::class,'mvmCompte'] );
    /*TRANSACTION END*/

    /*CONFIGURATIONS START*/
    Route::get('/service',[ConfigurationController::class,'service'] );
    Route::get('/apikey',[ConfigurationController::class,'apikey'] );
    Route::get('/reclamation',[ConfigurationController::class,'reclamation'] );
    /*CONFIGURATIONS END*/
});
