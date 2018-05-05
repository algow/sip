<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Satker;

class WaController extends Controller
{
    public function hubungi($id)
    {

        $query = Spm::find($id);
        $relation = $query['kode_satker'];
        $query_satker = Satker::find($relation);
        $kontak = $query_satker['whatsapp'];
        $spm = $query['kode'];
        $jenis = $query['jenis'];
        $diterima = strtotime($query['tanggal_terima']);
        $tanggal = date('d F Y', $diterima);
        $alasan = strtoupper($query['keterangan']);

        $pesan = 'Dengan%20ini%20kami%20informasikan%20bahwa%2C%0A%0A'
                  . $jenis . '%20saudara%20dengan%20nomor%20$spm' . $spm
                  . '%20yang%20disampaikan%20ke%20KPPN%20pada%20$tanggal%20'
                  . 'ditolak%20dengan%20alasan%20' . $alasan
                  . '%2E%0A%0AMohon%20untuk%20segera%20memperbaiki%20dan%20'
                  . 'menyampaikan%20kembali%20dokumen%20ke%20loket%20'
                  . 9 . '%20atau%20' . 10 . '%20KPPN%2E%Bantu%20kami%20mewujudkan'
                  . '%20Wilayah%20Bebas%20dari%20Korupsi%20%28WBK%29%20dan'
                  . '%20Wilayah%20Birokrasi%20Bersih%20dan%20Melayani%20%28WBBM%29'
                  . '%20dengan%20cara%20tidak%20memberikan%20gratifikasi%20dalam'
                  . '%20bentuk%20apapun%20kepada%20pegawai%20KPPN%20Jakarta%20III'
                  . '%2E0A%0A%2D%20KPPN%20Jakarta%20III%2E';

              /*
              Dengan ini kami informasikan bahwa:
              $jenis saudara dengan nomor $spm yang disampaikan ke KPPN pada $tanggal ditolak dengan alasan $alasan.
              Mohon untuk segera memperbaiki dan menyampaikan kembali dokumen ke loket 9 atau 10 KPPN.

              Bantu kami mewujudkan Wilayah Bebas dari Korupsi (WBK) dan Wilayah Birokrasi Bersih dan Melayani (WBBM)
              dengan cara tidak memberikan gratifikasi dalam bentuk apapun kepada para pegawai KPPN Jakarta III.
              */

        return redirect()->away('https://web.whatsapp.com/send?phone=' . $kontak . '&text=' . $pesan);
    }
    public function ajax()
    {
        $id = $_GET['kode'];

        $namaSatker = Satker::select('nama_satker','kode')->where('kode', $id)->get();
        return response()->json($namaSatker);
    }
}
