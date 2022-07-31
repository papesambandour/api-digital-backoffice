<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
  public function dashboard(): Factory|View|Application
  {
      return view('partners/dashboard.dashboard');
  }
  public function statistic(): Factory|View|Application
  {
      return view('partners/dashboard.statistic');
  }
}
