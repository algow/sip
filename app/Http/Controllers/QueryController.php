<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Petugas;

class QueryController extends Controller
{
    protected $satker;
    protected $tanggal;         // Tanggal database
    protected $tanggalTerima;   // Tanggal terformat untuk dioper ke view
    protected $jenis;
    protected $query;

    public function __construct($request)
    {
        $this->satker = $request->input('satker');
        $this->tanggal = $request->input('tanggal');
        $this->jenis = $request->input('jenis');
        $this->tanggalTerima = date('d F Y', strtotime($this->tanggal));
        $this->query();
    }
    
    // Mutator untuk property query
    protected function query()
    {
        $filter = [
            'jenis' => $this->jenis,
            'kode_satker' => $this->satker,
            'tanggal_terima' => $this->tanggal
        ];

        if(empty($filter['jenis']) && empty($filter['kode_satker']) && empty($filter['tanggal_terima'])) {
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
        return $this->tanggalTerima;
    }
    public function getJenis()
    {
        return $this->jenis;
    }
    public function getQuery()
    {
        return $this->query;
    }
}
