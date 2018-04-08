<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Petugas;
use Session;
use Validator;

class PengambilSpmController extends Controller
{
    public function diambil(Request $request)
    {     
        $this->validate($request, [
            'pengambil' => 'required|exists:petugas,barcode',
        ]);
        
        $pengambil = $request->input('pengambil');
        $id = $request->input('id');
        
        $diambil = Spm::find($id);
        $validasi = Petugas::where('barcode', $pengambil)->where('kode_satker', $diambil->kode_satker)->count();
        
        $message = '';
        
        if($validasi == 0)
        {
            $message = array('warning', 'Kode Satker tidak cocok dengan identitas petugas.');
        }
        else
        {
            $message = array('success', 'SPM Kontrak nomor' . " " . $diambil->kode . " " . 'telah diambil.');
            $diambil->tanda_terima = 1;
            $diambil->diambil_pada = date('Y-m-d');
            $diambil->pengambil = $pengambil;
            $diambil->save();
        }
        
        $jenis = $diambil->jenis;
        
        Session::flash("flash_notification", [
            "level"=>$message[0],
            "message"=>$message[1]
        ]);
        return redirect()->route('fo.telusuri',['jenis'=>$jenis,'satker'=>'','tanggal'=>'']);
    }
}