<?php

namespace App\Http\Controllers;

// http://github.com/ConsoleTVs/Charts

use Illuminate\Http\Request;
use Charts;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Kontrak;
use App\Supplier;

class ChartController extends Controller
{
    protected $dates = array();
    protected $gabungDiambil = array();
    protected $gabungDiterima = array();

    public function index()
    {
        $this->dateRange();
        $this->diambil();
        $this->diterima();
        
        $tanggal = array();
        $i = 0;
        
        foreach($this->dates as $date){
            $value = strtotime($date);
            $tanggal[$i] = date("j M", $value);
            $i++;
        }

        $chart = Charts::multi('areaspline', 'highcharts')
            // Setup the chart settings
            ->title('Tingkat Pengambilan SPM Tertolak')
            ->colors(['#FF0000', '#0c0099'])
            ->labels($tanggal)
            ->dataset('Diterima', $this->gabungDiterima)
            ->dataset('Diambil', $this->gabungDiambil);
        return view('home', ['chart' => $chart]);
    }
    
    public function dateRange()
    {
        $now = date("Y-m-d");
	$dstring = strtotime("6 weeks ago");
	$then = date("Y-m-d", $dstring);

	$begin = new DateTime($then);
	$end = new DateTime($now);
	$ends = $end->modify( '+1 day' ); 

	$interval = new DateInterval('P1D');
	$daterange = new DatePeriod($begin, $interval ,$ends);
        
        $i = 0;
        foreach($daterange as $date){
            $cond = $date->format("N");
                if ($cond < 6) {
                    $this->dates[$i] = $date->format("Y-m-d");
                }
            $i++;
        }
    }
    
    public function diambil()
    {
        $i = 0;
        
        foreach($this->dates as $date){
            $kontrak[$i] = Kontrak::where('tanda_terima', 1)
                            ->where('tanggal_terima', $date)
                            ->count();
            $supplier[$i] = Supplier::where('tanda_terima', 1)
                            ->where('tanggal_terima', $date)
                            ->count();
            
            $this->gabungDiambil[$i] = $kontrak[$i] + $supplier[$i];
            $i++;
        }
    }
    
    public function diterima()
    {
        $i = 0;
        
        foreach($this->dates as $date){
            $kontrak[$i] = Kontrak::where('tanggal_terima', $date)
                            ->count();
            $supplier[$i] = Supplier::where('tanggal_terima', $date)
                            ->count();
            
            $this->gabungDiterima[$i] = $kontrak[$i] + $supplier[$i];
            $i++;
        }
    }
}