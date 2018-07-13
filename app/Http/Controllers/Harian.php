<?php

namespace App\Http\Controllers;

use Charts;
use DateTime;
use DateInterval;
use DatePeriod;

// Dipanggil dari HomeController

Class Harian Extends Chart {

		private $dates = [];
    private $diambil = [];
    private $diterima = [];

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
            ->dataset('Diterima', $this->diterima)
            ->dataset('Diambil', $this->diambil);
        return view('home', ['chart' => $chart]);
    }

    private function dateRange()
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

    private function diambil()
    {
        $i = 0;

        foreach($this->dates as $date){
            $spm[$i] = $this->query->where('tanda_terima', 1)
                            ->where('diambil_pada', $date)
                            ->count();

            $this->diambil[$i] = $spm[$i];
            $i++;
        }
    }

    private function diterima()
    {
        $i = 0;

        foreach($this->dates as $date){
            $spm[$i] = $this->query->where('tanggal_terima', $date)
                            ->count();

            $this->diterima[$i] = $spm[$i];
            $i++;
        }
    }
}
