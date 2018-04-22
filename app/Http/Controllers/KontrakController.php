<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use Validator;
use Session;
use App\Http\Controllers\PrefixController as Prefix;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Prefix $prefix)
    {
        return redirect()->route($prefix->getPrefix() . '.telusuri',['jenis'=>'kontrak','satker'=>'','tanggal'=>'']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form_filler = array('kontrak', 'Nomor Kontrak', 'Nilai Kontrak');
        return view('spm.create')->with('spm', $form_filler);
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
            'kode' => 'required|unique:spms,kode',
            'nama_supplier' => 'required',
            'nilai_spm' => 'required|numeric',
            'keterangan' => 'required|file',
            'tanggal_terima' => 'required|date'
        ]);
        $kontrak = Spm::create($request->all());
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan SPM nomor $kontrak->kode"
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
        $find = Spm::find($id);
        $form_filler = array('kontrak', 'Nomor Kontrak', 'Nilai Kontrak');
        return view('spm.edit')->with(compact('find'))->with('id', $id)->with('spm', $form_filler);
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
            'nilai_spm' => 'required|numeric',
            'keterangan' => 'required'       
          ]);
        $kontrak = Spm::find($id);
        $kontrak->update($request->all());
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil mengubah SPM nomor $kontrak->kode"
        ]);
        return redirect()->route('admin.telusuri',['jenis'=>'kontrak','satker'=>'','tanggal'=>'']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Spm::destroy($id);
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menghapus SPM"
        ]);
        return redirect()->route('admin.telusuri',['jenis'=>'kontrak','satker'=>'','tanggal'=>'']);
    }
}