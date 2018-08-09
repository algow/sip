<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Spm;
use Validator;
use App\Http\Controllers\Prefix;
use App\Http\Controllers\SmsGateway as Sms;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Prefix $prefix)
    {
        return redirect()->route($prefix->getPrefix() . '.telusuri',['jenis'=>'spm','satker'=>'','tanggal'=>'','direkam'=>'']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form_filler = array('spm', 'Kode SPM', 'Nilai SPM', 'Tanggal SPM');
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
        // $cekDuplikat = ['kode_satker', 'kode', 'tanggal_spm', 'nama_supplier', 'nilai_spm', 'keterangan', 'jenis'];

        $this->validate($request, [
            'kode_satker' => 'required|size:6|exists:satkers,kode',
            'kode' => 'required|size:5',
            'nama_supplier' => 'required',
            'tanggal_spm' => 'required|date',
            'nilai_spm' => 'required|numeric',
            'tanggal_terima' => 'required|date'
        ]);

        $cegahSms = $request->input('cegah_sms');

        $spm = Spm::create($request->all());
        $loadSatker = $spm->load('satker');

        $toArray = ['whatsapp' => $loadSatker->satker->whatsapp,
                    'jenis' => $loadSatker->jenis,
                    'kode' => $loadSatker->kode,
                    'tanggal_terima' => $loadSatker->tanggal_terima,
                    'satker' => $loadSatker->kode_satker
                  ];

        if(empty($cegahSms) && !empty($toArray['whatsapp']))
        {
            $sms = new Sms($toArray);
            $sms->send();
        }

        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan SPM nomor $spm->kode"
        ]);
        return redirect()->route('spm.create');
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
        $form_filler = array('spm', 'Kode SPM', 'Nilai SPM', 'Tanggal SPM', 'Edit');
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
            'kode' => 'required|size:5',
            'tanggal_terima' => 'required|date',
            'nama_supplier' => 'required',
            'tanggal_spm' => 'required|date',
            'nilai_spm' => 'required|numeric',
          ]);
        $spm = Spm::find($id);
        $spm->update($request->all());

        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil mengubah SPM nomor $spm->kode"
        ]);
        return redirect()->route('admin.telusuri',['jenis'=>'spm','satker'=>'','tanggal'=>'']);
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
        return redirect()->route('admin.telusuri',['jenis'=>'spm','satker'=>'','tanggal'=>'']);
    }
}
