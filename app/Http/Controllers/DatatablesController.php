<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController as QueryController;
use Yajra\DataTables\DataTables;

class DatatablesController extends Controller
{
    
    protected $query;
    
    public function __construct($request)
    {
        $this->query = new QueryController($request);
    }
    
    public function prefix($prefix)
    {
        $theprefix = $prefix->getPrefix();
        
        return $theprefix;
    }
        
    public function spm($request, $htmlBuilder, $prefix)
    {
        $jenis = $request->input('jenis');
                
        if ($request->ajax()) {
            $spm = $this->query->getQuery();
            return DataTables::of($spm)
                ->addColumn('action', function($spm) use($jenis, $prefix){
                    return view('datatable._aksi', [
                        'model' => $spm,
                        'edit_url' => route($jenis . '.edit', $spm->id),
                        'kontak' => route('spm.whatsapp', $spm->id),
                        'tanggal' => $spm->diambil_pada,
                        'prefix' => $this->prefix($prefix),
                        'pengambil' => $spm->pengambil,
                        'id' => $spm->id
                    ]);
                })
                ->editColumn('tanggal_spm', function ($spm) {
                  return date('d F Y', strtotime($spm->tanggal_spm));
                })
                ->editColumn('nilai_spm', function ($spm) {
                  return number_format($spm->nilai_spm, 0, '.', '.');
                })
                ->editColumn('diambil_pada', function ($spm) {
                  if (is_null($spm['diambil_pada'])) {
                    return '';
                  }
                  else {
                    return date('d F Y', strtotime($spm->diambil_pada) );
                  }
                })
                ->editColumn('tanggal_terima', function ($spm) {
                        return date('d F Y', strtotime($spm->tanggal_terima));
                })
            ->make(true);            
        }
        
        $html = '';
        
        if($jenis === 'supplier')
        {
            $html = $htmlBuilder
                ->addColumn(['data' => 'kode_satker', 'name'=>'kode_satker', 'title'=>'Kode Satker'])
                ->addColumn(['data' => 'nama_supplier', 'name'=>'nama_supplier', 'title'=>'Nama Supplier'])
                ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'Nomor SPM'])
                ->addColumn(['data' => 'tanggal_spm', 'name'=>'tanggal_spm', 'title'=>'Tanggal SPM'])
                ->addColumn(['data' => 'nilai_spm', 'name'=>'nilai_spm', 'title'=>'Nilai SPM'])
                ->addColumn(['data' => 'keterangan', 'name'=>'keterangan', 'title'=>'Keterangan'])
                ->addColumn(['data' => 'diambil_pada', 'name'=>'diambil_pada', 'title'=>'Diambil Pada'])
                ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'Aksi', 'orderable'=>false, 'searchable'=>false]);
        }
        else {
            $html = $htmlBuilder
                ->addColumn(['data' => 'kode_satker', 'name'=>'kode_satker', 'title'=>'Kode Satker'])
                ->addColumn(['data' => 'nama_supplier', 'name'=>'nama_supplier', 'title'=>'Nama Supplier'])
                ->addColumn(['data' => 'tanggal_terima', 'name'=>'tanggal_terima', 'title'=>'Tgl Terima FO'])
                ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'No Kontrak'])
                ->addColumn(['data' => 'nilai_spm', 'name'=>'nilai_spm', 'title'=>'Nilai Kontrak'])
                ->addColumn(['data' => 'keterangan', 'name'=>'keterangan', 'title'=>'Keterangan'])
                ->addColumn(['data' => 'diambil_pada', 'name'=>'diambil_pada', 'title'=>'Diambil Pada'])
                ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'Aksi', 'orderable'=>false, 'searchable'=>false]);
        }
        return view('spm.index')->with(compact('html'))
                    ->with('jenis', $jenis)
                    ->with('satker', $this->query->getSatker())
                    ->with('tanggal', $this->query->dbTanggal())
                    ->with('tanggal_terima', $this->query->getTanggal());
    }
}