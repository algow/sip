<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Petugas;
use App\Anakkips;
use Session;
use Validator;

class PengambilSpmController extends Controller
{
    public function diambil(Request $request)
    {   
        $pengambil = $this->getInput($request);
        $message = $this->validasi($request, $pengambil);
                
        Session::flash("flash_notification", [
            "level"=>$message[0],
            "message"=>$message[1]
        ]);
        return redirect()->route('fo.telusuri',['jenis'=>'','satker'=>'','tanggal'=>'']);
    }    
    public function getInput($request)
    {
        $this->validate($request, [
            'pengambil' => 'required',
        ]);
        
        $scan = $request->input('pengambil');
                
        $pengambil = base_convert($scan, 36, 10);
        
        if (strlen($scan) === 16)
        {
            $pengambil = $scan;
        }
        
        return $pengambil;
    }
    public function getSpm($request)
    {
        $id = $request->input('id');
        $spm = Spm::find($id);
        
        return $spm;
    }
    public function validasi($request, $pengambil)
    {
        $spm = $this->getSpm($request);
                
        $validasi1 = Petugas::where('barcode', $pengambil)->where('kode_satker', $spm->kode_satker)->first();
        $petugas = Petugas::where('barcode', $pengambil)->first();
        
        if (is_null($petugas))
        {
            $validasi2 = null;
        }
        else {
            $validasi2 = Anakkips::where('kode_satker', $petugas->kode_satker)->where('anak_satker', $spm->kode_satker)->first();
        }
        
        if (is_null($validasi1) && is_null($validasi2))
        {
            $message = array('warning', 'Kode Satker tidak cocok dengan identitas petugas.');
        }
        else
        {
            $message = array('success', 'SPM Kontrak nomor' . " " . $spm->kode . " " . 'telah diambil.');
            $spm->tanda_terima = 1;
            $spm->diambil_pada = date('Y-m-d');
            $spm->pengambil = $pengambil;
            $spm->save();
        }
        return $message;
    }
}