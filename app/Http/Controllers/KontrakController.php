<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Kontrak;
use Validator;
use Session;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $query_kontrak = Kontrak::all();
            return Datatables::of($query_kontrak)
              ->addColumn('action', function($kontrak){
                return view('datatable._aksi', [
                    'edit_url' => route('kontrak.edit', $kontrak->id),
                    'kontak' => route('kontrak.whatsapp', $kontrak->id),
                    'tanggal' => $kontrak['diambil_pada']
                ]);
            })
              ->editColumn('nilai_kontrak', function ($kontrak) {
                  return number_format($kontrak->nilai_kontrak, 0, '.', '.');
            })
              ->editColumn('diambil_pada', function ($kontrak) {
                  if (is_null($kontrak['diambil_pada'])) {
                    return '';
                  }
                  else {
                    return date('d F Y', strtotime($kontrak->diambil_pada) );
                  }
            })
              ->editColumn('tanggal_terima', function ($kontrak) {
                return date('d F Y', strtotime($kontrak->tanggal_terima));
            })->make(true);
        }
        $html = $htmlBuilder
            ->addColumn(['data' => 'kode_satker', 'name'=>'kode_satker', 'title'=>'Kode Satker'])
            ->addColumn(['data' => 'nama_supplier', 'name'=>'nama_supplier', 'title'=>'Nama Supplier'])
            ->addColumn(['data' => 'tanggal_terima', 'name'=>'tanggal_terima', 'title'=>'Tgl Terima FO'])
            ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'No Kontrak'])
            ->addColumn(['data' => 'nilai_kontrak', 'name'=>'nilai_kontrak', 'title'=>'Nilai Kontrak'])
            ->addColumn(['data' => 'keterangan', 'name'=>'keterangan', 'title'=>'Keterangan'])
            ->addColumn(['data' => 'diambil_pada', 'name'=>'diambil_pada', 'title'=>'Diambil Pada'])
            ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'Aksi', 'orderable'=>false, 'searchable'=>false]);
        return view('kontrak.admin.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kontrak.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_satker' => 'required|size:6|exists:satkers,kode',
            'kode' => 'required',
            'nama_supplier' => 'required',
            'nilai_kontrak' => 'required|numeric',
            'keterangan' => 'required',
            'tanggal_terima' => 'required|date'
            ]);
        $kontrak = Kontrak::create($request->all());
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan Kontrak nomor $kontrak->kode"
        ]);
        return redirect()->route('kontrak.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kontrak = Kontrak::find($id);
        return view('kontrak.admin.edit')->with(compact('kontrak'))->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kode_satker' => 'required|size:6|exists:satkers,kode',
            'kode' => 'required',
            'nama_supplier' => 'required',
            'nilai_kontrak' => 'required|numeric',
            'keterangan' => 'required'       
          ]);
        $kontrak = Kontrak::find($id);
        $kontrak->update($request->all());
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil mengubah Kontrak nomor $kontrak->kode"
        ]);
        return redirect()->route('kontrak.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
