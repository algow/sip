<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laratrust\LaratrustFacade as Laratrust;
use App\Http\Controllers\ChartController as ChartController;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Laratrust::hasRole('front_office')) {
            return redirect('fo/filter');
        }
        elseif(Laratrust::hasRole('admin')) {
            $chart = new ChartController;
            return $chart->index();
        }
        else {
            return redirect('login');
        }
    }
    public function redirect()
    {
        
    }
}
