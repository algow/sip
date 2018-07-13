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
        $pengambil = $this->getInput($request);             // Ambil input barcode dari user
        $message = $this->validasi($request, $pengambil);   // Validasi dan simpan

        Session::flash("flash_notification", [
            "level"=>$message[0],
            "message"=>$message[1]
        ]);
        return response()->json($message);
    }
    private function getInput($request)
    {
        $scan = $request->input('pengambil');
        $pengambil = base_convert($scan, 36, 10);

        if (strlen($scan) === 16)
        {
            $pengambil = $scan;
        }
        return $pengambil;
    }
    private function getSpm($request)
    {
        $id = $request->input('id');
        $spm = Spm::find($id);

        return $spm;
    }
    private function validasi($request, $pengambil)
    {
        $spm = $this->getSpm($request);

        $queryPetugas = Petugas::where('barcode', $pengambil);
        $petugas = $queryPetugas->first();      // Does it exist inside the database?
        $validasi1 = $queryPetugas->where('kode_satker', $spm->kode_satker)->first();   // Nyocokno petugas mbek satkere

        if (is_null($petugas)) {
            $validasi2 = null;
        } else {
            $validasi2 = Anakkips::where('kode_satker', $petugas->kode_satker)
                        ->where('anak_satker', $spm->kode_satker)->first();     // Dicobo goleki nang anak satker
        }

        if (is_null($validasi1) && is_null($validasi2)) {
            $message = array('warning', 'Kode Satker tidak cocok dengan identitas petugas.');
        } else {
            $spm->tanda_terima = 1;
            $spm->diambil_pada = date('Y-m-d H:i:s');
            $spm->pengambil = $pengambil;
            $spm->save();
            $message = array('success', $validasi1->nama_petugas);
        }

        return $message;
    }
}
