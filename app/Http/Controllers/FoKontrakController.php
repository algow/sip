<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Kontrak;
use FoFilterController;
use Session;

class FoKontrakController extends Controller
{
    public function getIndex() {
        return view('kontrak.fo.index');
    }
    public function getQuery() {
                
        $kontrak = Kontrak::all();
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
    public function getAmbil($id) {        
        $sudah = Kontrak::find($id);

        $sudah->tanda_terima = 1;
        $sudah->diambil_pada = date('Y-m-d');

        $sudah->save();
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Kontrak nomor $sudah->kode telah diambil oleh petugas satker"
        ]);
        return redirect()->route('kontrak');
    }
}