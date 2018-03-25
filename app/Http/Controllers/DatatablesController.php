<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\QueryController as QueryController;
use Yajra\DataTables\DataTables;

class DatatablesController extends Controller
{
    
    protected $query;
    
    public function __construct(Request $request)
    {
        $this->query = new QueryController($request);
    }
    
    public function supplier($request, $htmlBuilder)
    {
        if ($request->ajax()) {
            $query_supplier = $this->query->getQuery();
            return DataTables::of($query_supplier)
                ->addColumn('action', function($supplier){
                    return view('datatable._aksi', [
                        'edit_url' => route('supplier.edit', $supplier->id),
                        'kontak' => route('supplier.whatsapp', $supplier->id),
                        'tanggal' => $supplier->diambil_pada
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
                })
            ->make(true);            
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
                    ->with('jenis', 'supplier')
                    ->with('satker', $this->query->getSatker())
                    ->with('tanggal', $this->query->dbTanggal())
                    ->with('tanggal_terima', $this->query->getTanggal());
    }
    public function kontrak($request, $htmlBuilder)
    {
        if ($request->ajax()) {
                $query_kontrak = $this->query->getQuery();
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
                    ->with('jenis', 'kontrak')
                    ->with('satker', $this->query->getSatker())
                    ->with('tanggal', $this->query->dbTanggal())
                    ->with('tanggal_terima', $this->query->getTanggal());
    }
}