<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Petugas;

class QueryController extends Controller
{
    protected $satker;
    protected $tanggal;    // Tanggal database
    protected $jenis;
    protected $direkam;     // Tanggal input
    protected $query;

    public function __construct($request)
    {
        $this->satker = $request->input('satker');
        $this->tanggal = $request->input('tanggal');
        $this->jenis = $request->input('jenis');
        $this->direkam = $request->input('direkam');
        $this->setQuery();
    }

    // Mutator untuk property query
    protected function setQuery()
    {
        $filter = [
            'jenis' => $this->jenis,
            'kode_satker' => $this->satker,
            'tanggal_terima' => $this->tanggal,
            'created_at' => $this->direkam
        ];

        if(empty($filter['jenis']) && empty($filter['kode_satker']) && empty($filter['tanggal_terima']) && empty($filter['jenis'])) {
            $this->query = Spm::with('petugas')->get();
        }
        else {
            foreach ($filter as $key => $value) {
                if(!empty($value)) {
                    $condArray[$key] = $value;
                }
            }
            $this->query = Spm::with('petugas')->where($condArray)->get();
        }
    }

    public function getSatker()
    {
        return $this->satker;
    }
    public function dbTanggal()
    {
        return $this->tanggal;
    }
    public function getTanggal()
    {
        $tanggalTerima = date('d F Y', strtotime($this->tanggal));
        return $tanggalTerima;
    }
    public function getJenis()
    {
        return $this->jenis;
    }
    public function getRekam()
    {
        $tanggalRekam = date('d F Y', strtotime($this->direkam));
        return $tanggalRekam;
    }
    public function getQuery()
    {
        return $this->query;
    }
}
