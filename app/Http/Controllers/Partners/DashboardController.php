<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Services\Partners\Metier\ConfigServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    private ConfigServices $configServices;

    /**
     * @param ConfigServices $configServices
     */
    public function __construct(ConfigServices $configServices)
    {
        $this->configServices = $configServices;
    }
  public function dashboard(): Factory|View|Application
  {
      $services  = $this->configServices->services();
      return view('partners/dashboard.dashboard',compact('services'));
  }
  public function home(): Factory|View|Application
  {
      return view('partners/dashboard.home');
  }
  public function statistic(): Factory|View|Application
  {
      return view('partners/dashboard.statistic');
  }
}
