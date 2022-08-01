<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Services\Partners\Metier\ConfigServices;
use App\Services\Partners\Metier\TransactionServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ConfigurationController extends Controller
{
    private ConfigServices $configServices;

    /**
     * @param ConfigServices $configServices
     */
    public function __construct(ConfigServices $configServices)
    {
        $this->configServices = $configServices;
    }
    public function service(): Factory|View|Application
    {
        $sousServices = $this->configServices->servicesPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('partners/config.service',compact('sousServices','date_start','date_end'));
    }
    public function apikey(): Factory|View|Application
    {
        $apisKeys = $this->configServices->apikeyPaginate();
        $date_start= request('date_start');
        $date_end= request('date_end');
        return view('partners/config.apikey',compact('apisKeys','date_start','date_end'));
    }
    public function addKey(){
        $this->configServices->addKey();
        return redirect()->back()->with('success','Votre clef est ajouté avec succès');
    }
    public function regenerateKey($idKey){
        $this->configServices->regenerateKey($idKey);
        return redirect()->back()->with('success','Votre clef est régénéré avec succès');
    }
    public function reclamation(): Factory|View|Application
    {
        return view('partners/config.reclamation');
    }

}
