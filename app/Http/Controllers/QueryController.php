<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Petugas;

class QueryController extends Controller
{
    protected $satker;
    protected $tanggal;
    protected $tanggalTerima;
    protected $jenis;
    protected $query;

    public function __construct($request)
    {
        $this->satker = $request->input('satker');
        $this->tanggal = $request->input('tanggal');
        $this->jenis = $request->input('jenis');
        $this->tanggalTerima = date('d F Y', strtotime($this->tanggal));
        $this->query();

/*        if(empty($this->jenis))
        {
            if (isset($this->query_satker) && empty($this->query_tanggal)) {
                $this->query = Spm::with('petugas')->where('kode_satker', $this->query_satker)->get();
            }
            elseif (isset($this->query_tanggal) && empty($this->query_satker)) {
                $this->query = Spm::with('petugas')->where('tanggal_terima', $this->query_tanggal)->get();
            }
            elseif (isset($this->query_satker) && isset($this->query_tanggal)) {
                $this->query = Spm::with('petugas')->where('kode_satker', $this->query_satker)
                        ->where('tanggal_terima', $this->query_tanggal)->get();
            }
            else {
                $this->query = Spm::with('petugas')->get();
            }
        }
        else
        {
            if (isset($this->query_satker) && empty($this->query_tanggal)) {
                $this->query = Spm::with('petugas')->where('kode_satker', $this->query_satker)
                        ->where('jenis', $this->jenis)->get();
            }
            elseif (isset($this->query_tanggal) && empty($this->query_satker)) {
                $this->query = Spm::with('petugas')->where('tanggal_terima', $this->query_tanggal)
                        ->where('jenis', $this->jenis)->get();
            }
            elseif (isset($this->query_satker) && isset($this->query_tanggal)) {
                $this->query = Spm::with('petugas')->where('kode_satker', $this->query_satker)
                        ->where('tanggal_terima', $this->query_tanggal)
                        ->where('jenis', $this->jenis)->get();
            }
            else {
                $this->query = Spm::with('petugas')->where('jenis', $this->jenis)->get();
            }
        }
*/    }

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
