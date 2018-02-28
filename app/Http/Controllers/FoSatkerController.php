<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Satker;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;

class FoSatkerController extends Controller
{
    public function index(Request $request, Builder $htmlBuilder){ 
        if ($request->ajax()) {
            $query_satker = Satker::select(['kode', 'nama_satker', 'whatsapp']);
            return Datatables::of($query_satker)->make(true);
        }
        $html = $htmlBuilder
            ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'Kode Satker'])       
            ->addColumn(['data' => 'nama_satker', 'name'=>'nama_satker', 'title'=>'Nama Satker'])
            ->addColumn(['data' => 'whatsapp', 'name'=>'whatsapp', 'title'=>'Nomor Kontak']);
        return view('satker.index')->with(compact('html'));
    }
}