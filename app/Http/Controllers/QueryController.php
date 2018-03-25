<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Supplier;
use App\Kontrak;

class QueryController extends Controller
{
    
    protected $query_satker;
    protected $query_tanggal;
    protected $tanggal_terima;
    protected $jenis;
    protected $query;
    
    public function __construct($request) {
        $this->query_satker = $request->input('satker');
        $this->query_tanggal = $request->input('tanggal');
        $this->jenis = $request->input('jenis');
        $this->tanggal_terima = date('d F Y', strtotime($this->query_tanggal));
        
        if($this->jenis === 'supplier')
        {
            if (isset($this->query_satker) && empty($this->query_tanggal)) {
                $this->query = Supplier::where('kode_satker', $this->query_satker)->get();
            }
            elseif (isset($this->query_tanggal) && empty($this->query_satker)) {
                $this->query = Supplier::where('tanggal_terima', $this->query_tanggal)->get();
            }
            elseif (isset($this->query_satker) && isset($this->query_tanggal)) {
                $this->query = Supplier::where('kode_satker', $this->query_satker)
                        ->where('tanggal_terima', $this->query_tanggal)->get();
            }
            else {
                $this->query = Supplier::all();
            }
        }
        else
        {
            if (isset($this->query_satker) && empty($this->query_tanggal)) {
                $this->query = Kontrak::where('kode_satker', $this->query_satker)->get();
            }
            elseif (isset($this->query_tanggal) && empty($this->query_satker)) {
                $this->query = Kontrak::where('tanggal_terima', $this->query_tanggal)->get();
            }
            elseif (isset($this->query_satker) && isset($this->query_tanggal)) {
                $this->query = Kontrak::where('kode_satker', $this->query_satker)
                        ->where('tanggal_terima', $this->query_tanggal)->get();
            }
            else {
                $this->query = Kontrak::all();
            }
        }
            
    }
    
    public function getSatker(){
        return $this->query_satker;
    }
    public function dbTanggal(){
        return $this->query_tanggal;
    }
    public function getTanggal(){
        return $this->tanggal_terima;
    }
    public function getQuery(){
        return $this->query;
    }
}