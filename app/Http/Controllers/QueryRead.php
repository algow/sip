<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Petugas;

class QueryRead
{
    private $satker;
    private $tanggal;
    private $jenis;
    private $direkam;
    private $query;

    public function __construct($request)
    {
        $this->satker = $request->input('satker');
        $this->tanggal = $request->input('tanggal');
        $this->tanggal2 = $request->input('tanggal2');
        $this->jenis = $request->input('jenis');
        $this->setQuery();
    }

    private function setQuery()
    {
        $cond = $condBetween = null;
        if(!empty($this->tanggal2)) {
            $begin = date("Y-m-d", strtotime($this->tanggal));
            $end = date("Y-m-d", strtotime($this->tanggal2));
            $date = [$begin, $end];
        } else {
            $date = $this->tanggal;
        }

        $filter = [
            'jenis' => $this->jenis,
            'kode_satker' => $this->satker,
            'tanggal_terima' => $date
        ];

        foreach ($filter as $key => $value) {
            if(!empty($value)) {
                $cond[$key] = $value;
                if(is_array($value)) {
                    array_pop($cond);
                    $condBetween = $value;
                }
            }
        }

        if(!is_null($cond) && !is_null($condBetween)) {
            $this->query = Spm::with('petugas')->where($cond)->whereBetween('tanggal_terima', $condBetween)->get();
        } elseif (!is_null($cond) && is_null($condBetween)) {
            $this->query = Spm::with('petugas')->where($cond)->get();
        } elseif (is_null($cond) && !is_null($condBetween)) {
            $this->query = Spm::with('petugas')->whereBetween('tanggal_terima', $condBetween)->get();
        } else {
            $this->query = Spm::with('petugas')->get();
        }
    }

    public function getSatker()
    {
        return $this->satker;
    }
    public function dbTanggal()     // Tanggal mentahan dari database
    {
        return $this->tanggal;
    }
    public function getTanggal()    // Tanggal fungsi sebelumnya tapi dah diformat
    {
        $tanggalTerima = date('d F Y', strtotime($this->tanggal));
        return $tanggalTerima;
    }
    public function getJenis()
    {
        return $this->jenis;
    }
    public function dbRekam()     // Input tanggal mentahan dari database
    {
        return $this->direkam;
    }
    public function getRekam()  // Input tanggal tapi dah diformat
    {
        $tanggalRekam = date('d F Y', strtotime($this->direkam));
        return $tanggalRekam;
    }
    public function getQuery()
    {
        return $this->query;
    }
}
