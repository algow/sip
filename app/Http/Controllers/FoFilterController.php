<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Validator;
use App\Http\Controllers\QueryController as QueryController;

class FoFilterController extends Controller
{
    
    public function form()
    {
        $route = 'fo.telusuri';
        return view('filter.index')->with('route', $route);
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
                $route = "kontrak.ajax";
                return view('kontrak.fo.index')
                        ->with('route', $route)
                        ->with('jenis', $query_jenis)
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
                $route = "supplier.ajax";
                return view('supplier.fo.index')
                        ->with('route', $route)
                        ->with('jenis', $query_jenis)
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
        $query = new QueryController($request);
        $supplier = $query->getQuery();
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
        $query = new QueryController($request);
        $kontrak = $query->getQuery();
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