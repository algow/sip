<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Supplier;
use Session;

class FoSupplierController extends Controller
{
    public function getIndex() {
        return view('supplier.fo.index');
    }
    public function getQuery() {
        $supplier = Supplier::all();
        return Datatables::of($supplier)
          ->editColumn('diambil_pada', function ($supplier) {
            if (is_null($supplier['diambil_pada'])) {
                return '';
            }
            else {
                return date('d F Y', strtotime($supplier->diambil_pada) );
            }
          })
          ->addColumn('action', function($supplier){
            if (is_null($supplier['diambil_pada'])) {
                return '<a class="btn-xs btn-success" href="'.route('get.supplier.tandai', $supplier->id).'" title="tandai sebagai sudah diambil"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>';
            }
          })
          ->editColumn('tanggal_spm', function ($supplier) {
                return date('d F Y', strtotime($supplier->tanggal_spm) );
          })
        ->make(true);
    }
    public function getAmbil($id) {        
        $sudah = Supplier::find($id);

        $sudah->tanda_terima = 1;
        $sudah->diambil_pada = date('Y-m-d');
        $sudah->save();
        
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Kontrak nomor $sudah->kode telah diambil oleh petugas satker"
        ]);
        return redirect()->route('supplier');
    }
}
