<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kontrak;
use App\Satker;
use App\Supplier;
use Laratrust\LaratrustFacade as Laratrust;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use Validator;

class FilterController extends Controller
{
    public function filter(){
        return view('filter.index');
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
        
        $pesan = 'Salam%20perbendaharaan%2E%0A%0ASaya%20petugas%20KPPN%20Jakarta%20III%20menginformasikan%20bahwa%20'
                . 'SPM%20kontrak%20dengan%20nomor%20' . $spm
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
    public function index(Request $request, Builder $htmlBuilder)
    {
        $this->validate($request, [
            'jenis' => 'required',
        ]);
        
        $query = "";

        $query_jenis = $request->input('jenis');
        $query_satker = $request->input('satker');
        $query_tanggal = $request->input('tanggal');
        $tanggal_terima = date('d F Y', strtotime($query_tanggal));

        if ($query_jenis === "supplier") {

            if (isset($query_satker) && empty($query_tanggal)) {
                $query = Supplier::where('kode_satker', $query_satker)->get();
            }
            if (isset($query_tanggal) && empty($query_satker)) {
                $query = Supplier::where('tanggal_terima', $query_tanggal)->get();
            }
            if (isset($query_satker) && isset($query_tanggal)) {
                $query = Supplier::where('kode_satker', $query_satker)->where('tanggal_terima', $query_tanggal);
            }
            if (empty($query_tanggal) && empty($query_satker)) {
                return redirect()->route("supplier.index");
            }

            if ($request->ajax()) {
                $query_supplier = $query;
                return Datatables::of($query_supplier)->addColumn('action', function($supplier){
                    return view('datatable._aksi', [
                        'model' => $supplier,
                        'edit_url' => route('supplier.edit', $supplier->id),
                        'kontak' => route('supplier.whatsapp', $supplier->id),
                        'tanggal' => $supplier['diambil_pada']
                    ]);
                })
                ->editColumn('tanggal_spm', function ($supplier) {
                  return date('d F Y', strtotime($supplier->tanggal_spm));
                })
                ->editColumn('nilai_spm', function ($supplier) {
                  return number_format($supplier->nilai_spm, 0, '.', '.');
                })
                ->editColumn('diambil_pada', function ($supplier) {
                  if (is_null($supplier['diambil_pada'])) {
                    return '';
                  }
                  else {
                    return date('d F Y', strtotime($supplier->diambil_pada) );
                  }
                })->make(true);            
            }
            $html = $htmlBuilder
                ->addColumn(['data' => 'kode_satker', 'name'=>'kode_satker', 'title'=>'Kode Satker'])
                ->addColumn(['data' => 'nama_supplier', 'name'=>'nama_supplier', 'title'=>'Nama Supplier'])
                ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'Nomor SPM'])
                ->addColumn(['data' => 'tanggal_spm', 'name'=>'tanggal_spm', 'title'=>'Tanggal SPM'])
                ->addColumn(['data' => 'nilai_spm', 'name'=>'nilai_spm', 'title'=>'Nilai SPM'])
                ->addColumn(['data' => 'keterangan', 'name'=>'keterangan', 'title'=>'Keterangan'])
                ->addColumn(['data' => 'diambil_pada', 'name'=>'diambil_pada', 'title'=>'Diambil Pada'])
                ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'Aksi', 'orderable'=>false, 'searchable'=>false]);
            return view('supplier.admin.index')->with(compact('html'))
                    ->with('jenis', $query_jenis)
                    ->with('satker', $query_satker)
                    ->with('tanggal', $query_tanggal)
                    ->with('tanggal_terima', $tanggal_terima);
        }
        if ($query_jenis === "kontrak") {
            if (isset($query_satker) && empty($query_tanggal)) {
                $query = Kontrak::where('kode_satker', $query_satker)->get();
            }
            if (isset($query_tanggal) && empty($query_satker)) {
                $query = Kontrak::where('tanggal_terima', $query_tanggal)->get();
            }
            if (isset($query_satker) && isset($query_tanggal)) {
                $query = Kontrak::where('kode_satker', $query_satker)->where('tanggal_terima', $query_tanggal)->get();
            }
            if (empty($query_tanggal) && empty($query_satker)) {
                return redirect()->route("kontrak.index");
            }

            if ($request->ajax()) {
                $query_kontrak = $query;
                return Datatables::of($query_kontrak)
                  ->addColumn('action', function($kontrak){
                    return view('datatable._aksi', [
                        'model' => $kontrak,
                        'edit_url' => route('kontrak.edit', $kontrak->id),
                        'kontak' => route('kontrak.whatsapp', $kontrak->id),
                        'tanggal' => $kontrak['diambil_pada']
                  ]);
                })
                  ->editColumn('nilai_kontrak', function ($kontrak) {
                    return number_format($kontrak->nilai_kontrak, 0, '.', '.');
                })
                  ->editColumn('diambil_pada', function ($kontrak) {
                    if (is_null($kontrak['diambil_pada'])) {
                      return '';
                    }
                    else {
                        return date('d F Y', strtotime($kontrak->diambil_pada));
                    }
                })
                  ->editColumn('tanggal_terima', function ($kontrak) {
                        return date('d F Y', strtotime($kontrak->tanggal_terima));
                })->make(true);
            }
            $html = $htmlBuilder
                ->addColumn(['data' => 'kode_satker', 'name'=>'kode_satker', 'title'=>'Kode Satker'])
                ->addColumn(['data' => 'nama_supplier', 'name'=>'nama_supplier', 'title'=>'Nama Supplier'])
                ->addColumn(['data' => 'tanggal_terima', 'name'=>'tanggal_terima', 'title'=>'Tgl Terima FO'])
                ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'No Kontrak'])
                ->addColumn(['data' => 'nilai_kontrak', 'name'=>'nilai_kontrak', 'title'=>'Nilai Kontrak'])
                ->addColumn(['data' => 'keterangan', 'name'=>'keterangan', 'title'=>'Keterangan'])
                ->addColumn(['data' => 'diambil_pada', 'name'=>'diambil_pada', 'title'=>'Diambil Pada'])
                ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'Aksi', 'orderable'=>false, 'searchable'=>false]);
            return view('kontrak.admin.index')->with(compact('html'))
                    ->with('jenis', $query_jenis)
                    ->with('satker', $query_satker)
                    ->with('tanggal', $query_tanggal)
                    ->with('tanggal_terima', $tanggal_terima);
        }
    }
}