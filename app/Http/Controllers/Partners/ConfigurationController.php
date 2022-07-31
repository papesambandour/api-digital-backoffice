<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class ConfigurationController extends Controller
{
    public function service(): Factory|View|Application
    {
        return view('partners/config.service');
    }
    public function apikey(): Factory|View|Application
    {
        return view('partners/config.apikey');
    }
    public function reclamation(): Factory|View|Application
    {
        return view('partners/config.reclamation');
    }

}
