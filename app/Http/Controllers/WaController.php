<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Satker;

class WaController extends Controller
{
    public function hubungi($id){

        $query_supplier = Spm::find($id);
        $relation = $query_supplier['kode_satker'];
        $query_satker = Satker::find($relation);
        $kontak = $query_satker['whatsapp'];

        $spm = $query_supplier['kode'];
        $diterima = strtotime($query_supplier['tanggal_terima']);
        $tanggal = date('d F Y', $diterima);
        $alasan = strtoupper($query_supplier['keterangan']);

        $pesan = 'Salam%20perbendaharaan%2E%0A%0ASaya%20petugas%20KPPN%20Jakarta%20III%20'
                . 'menginformasikan%20bahwa%20SPM%20dengan%20nomor%20' . $spm
                . '%20yang%20disetorkan%20ke%20loket%20kami%20pada%20tanggal%20' . $tanggal
                . '%20telah%20ditolak%20pengajuannya%20dengan%20alasan%20%22' . $alasan . '%22'
                . '%2E%20%0AMohon%20untuk%20segera%20mengambil%20kembali%20berkas%20SPM%20tersebut'
                . '%20di%20loket%20pelayanan%20KPPN%20Jakarta%20III%2E%0A%0ABantu%20kami%20'
                . 'mewujudkan%20Wilayah%20Bebas%20dari%20Korupsi%20%28WBK%29%20dan%20Wilayah'
                . '%20Birokrasi%20Bersih%20dan%20Melayani%20(WBBM)%20dengan%20cara%20tidak'
                . '%20memberikan%20gratifikasi%20dalam%20bentuk%20apapun%20kepada%20para'
                . '%20pegawai%20KPPN%20Jakarta%20III%2E';

        return redirect()->away('https://web.whatsapp.com/send?phone=' . $kontak . '&text=' . $pesan);
    }
}
