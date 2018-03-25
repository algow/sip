<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Kontrak;
use Validator;
use Session;
use App\Http\Controllers\DatatablesController as IndexTable;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->away('http://localhost/sipen/public/admin/telusuri?jenis=kontrak&satker=&tanggal=');
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
