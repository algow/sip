<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Supplier;
use App\Kontrak;
use Validator;

class FoFilterController extends Controller
{
    public function form()
    {
        return view('filter.indexfo');
    }
    public function telusuri(Request $request)
    {
        $this->validate($request, [
            'jenis' => 'required',
        ]);
        
        $query_jenis = $request->input('jenis');
        $query_satker = $request->input('satker');
        $query_tanggal = $request->input('tanggal');
        $tanggal_terima = date('d F Y', strtotime($query_tanggal));
        
        if ($query_jenis === "kontrak") {
            if (isset($query_tanggal) || isset($query_satker)) {
                return view('filter.kontrakfo')->with('jenis', $query_jenis)
                        ->with('satker', $query_satker)
                        ->with('tanggal', $query_tanggal)
                        ->with('tanggal_terima', $tanggal_terima);
            }
            if (empty($query_tanggal) && empty($query_satker)) {
                return redirect()->route("kontrak");
            }
        }
        if ($query_jenis === "supplier") {
            if (isset($query_tanggal) || isset($query_satker)) {
                return view('filter.supplierfo')->with('jenis', $query_jenis)
                        ->with('satker', $query_satker)
                        ->with('tanggal', $query_tanggal)
                        ->with('tanggal_terima', $tanggal_terima);
            }
            if (empty($query_tanggal) && empty($query_satker)) {
                return redirect()->route("supplier");
            }
        }
    }
    public function supplierAjax(Request $request)
    {
        $query = "";

        $query_satker = $request->input('satker');
        $query_tanggal = $request->input('tanggal');
        
        if (isset($query_satker) && empty($query_tanggal)) {
            $query = Supplier::where('kode_satker', $query_satker);
        }
        if (isset($query_tanggal) && empty($query_satker)) {
            $query = Supplier::where('tanggal_terima', $query_tanggal);
        }
        if (isset($query_satker) && isset($query_tanggal)) {
            $query = Supplier::where('kode_satker', $query_satker)->where('tanggal_terima', $query_tanggal);
        }
        $supplier = $query;
        return Datatables::of($supplier)
          ->editColumn('diambil_pada', function ($supplier) {
            if (is_null($supplier['diambil_pada'])) {
                return '';
            }
            else {
                return date('d F Y', strtotime($supplier->diambil_pada) );
            }
          })
          ->editColumn('tanggal_spm', function ($supplier) {
                return date('d F Y', strtotime($supplier->tanggal_spm) );
          })
          ->addColumn('action', function($supplier){
            if (is_null($supplier['diambil_pada'])) {
                return '<a class="btn-xs btn-success" href="'.route('get.supplier.tandai', $supplier->id).'" title="tandai sebagai sudah diambil"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
            }
          })
        ->make(true);
    }
    public function kontrakAjax(Request $request)
    {
        $query = "";

        $query_satker = $request->input('satker');
        $query_tanggal = $request->input('tanggal');
        
        if (isset($query_satker) && empty($query_tanggal)) {
            $query = Kontrak::where('kode_satker', $query_satker);
        }
        if (isset($query_tanggal) && empty($query_satker)) {
            $query = Kontrak::where('tanggal_terima', $query_tanggal);
        }
        if (isset($query_satker) && isset($query_tanggal)) {
            $query = Kontrak::where('kode_satker', $query_satker)->where('tanggal_terima', $query_tanggal);
        }
        $kontrak = $query;
        return Datatables::of($kontrak)
          ->editColumn('diambil_pada', function ($kontrak) {
            if (is_null($kontrak['diambil_pada'])) {
                return '';
            }
            else {
                return date('d F Y', strtotime($kontrak->diambil_pada) );
            }
          })
          ->addColumn('action', function($kontrak){
            if (is_null($kontrak['diambil_pada'])) {
                return '<a class="btn-xs btn-success" href="'.route('get.kontrak.tandai', $kontrak->id).'" title="tandai sebagai sudah diambil"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
            }
          })
          ->editColumn('tanggal_terima', function ($kontrak) {
                return date('d F Y', strtotime($kontrak->tanggal_terima));
          })
        ->make(true);
    }
}