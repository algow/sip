<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kontrak;
use App\Satker;
use App\Supplier;
use Yajra\DataTables\DataTables;
use Validator;
use App\Http\Controllers\DatatablesController as IndexTable;
use Yajra\DataTables\Html\Builder;

class FilterController extends Controller
{
    public function filter(){
        $route = 'telusuri';
        return view('filter.index')->with('route', $route);
    }
    
    public function index(Request $request, IndexTable $indextable, Builder $htmlBuilder)
    {
        $this->validate($request, [
          'jenis' => 'required'
        ]);
        
        $jenis = $request->input('jenis');
        
        if($jenis === 'supplier')
        {
            return $indextable->supplier($request, $htmlBuilder);
        }
        else {
            return $indextable->kontrak($request, $htmlBuilder);
        }
    }    
    public function waSupplier($id){

            $query_supplier = Supplier::find($id);
            $relation = $query_supplier['kode_satker'];
            $query_satker = Satker::find($relation);
            $kontak = $query_satker['whatsapp'];
            $spm = $query_supplier['kode'];
            $diterima = strtotime($query_supplier['tanggal_terima']);
            $tanggal = date('d F Y', $diterima);
            $alasan = strtoupper($query_supplier['keterangan']);

            $pesan = 'Salam%20perbendaharaan%2E%0A%0ASaya%20petugas%20KPPN%20Jakarta%20III%20'
                    . 'menginformasikan%20bahwa%20SPM%20supplier%20dengan%20nomor%20' . $spm
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
    public function waKontrak($id){
        
        $query_kontrak = Kontrak::find($id);
        $relation = $query_kontrak['kode_satker'];
        $query_satker = Satker::find($relation);
        $kontak = $query_satker['whatsapp'];
        $spm = $query_kontrak['kode'];
        $diterima = strtotime($query_kontrak['tanggal_terima']);
        $tanggal = date('d F Y', $diterima);
        $alasan = strtoupper($query_kontrak['keterangan']);
        
        $pesan = 'Salam%20perbendaharaan%2E%0A%0ASaya%20petugas%20KPPN%20Jakarta%20III%20'
                . 'menginformasikan%20bahwa%20SPM%20kontrak%20dengan%20nomor%20' . $spm
                . '%20yang%20disetorkan%20ke%20loket%20kami%20pada%20tanggal%20' . $tanggal
                . '%20telah%20ditolak%20pengajuannya%20dengan%20alasan%20%22' . $alasan . '%22'
                . '%2E%20%0AMohon%20untuk%20segera%20mengambil%20kembali%20berkas%20SPM%20'
                . 'tersebut%20di%20loket%20pelayanan%20KPPN%20Jakarta%20III%2E%0A%0ABantu'
                . '%20kami%20mewujudkan%20Wilayah%20Bebas%20dari%20Korupsi%20%28WBK%29%20'
                . 'dan%20Wilayah%20Birokrasi%20Bersih%20dan%20Melayani%20(WBBM)%20dengan%20'
                . 'cara%20tidak%20memberikan%20gratifikasi%20dalam%20bentuk%20apapun%20kepada'
                . '%20para%20pegawai%20KPPN%20Jakarta%20III%2E';
        
        return redirect()->away('https://web.whatsapp.com/send?phone=' . $kontak . '&text=' . $pesan);
    }
}