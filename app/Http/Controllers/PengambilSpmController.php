<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use Session;
use Validator;

class PengambilSpmController extends Controller
{
    public function diambil(Request $request)
    {     
        $this->validate($request, [
            'pengambil' => 'required|string',
        ]);
        
        $pengambil = $request->input('pengambil');
        $id = $request->input('id');

        $diambil = Spm::find($id);

        $diambil->tanda_terima = 1;
        $diambil->diambil_pada = date('Y-m-d');
        $diambil->pengambil = $pengambil;
        $diambil->save();
        
        $jenis = $diambil->jenis;
        
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Kontrak nomor $diambil->kode telah diambil oleh $diambil->pengambil"
        ]);
        return redirect()->route('fo.telusuri',['jenis'=>$jenis,'satker'=>'','tanggal'=>'']);
    }

}
