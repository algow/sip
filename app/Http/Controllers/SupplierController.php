<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use App\Supplier;
use Validator;
use App\Satker;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $query_supplier = Supplier::all();
            return Datatables::of($query_supplier)
                ->addColumn('action', function($supplier){
                    return view('datatable._aksi', [
                        'model' => $supplier,
                        'edit_url' => route('supplier.edit', $supplier->id),
                        'kontak' => route('supplier.whatsapp', $supplier->id),
                        'tanggal' => $supplier['diambil_pada']
                    ]);
                })
                ->editColumn('tanggal_spm', function ($supplier) {
                  return date('d F Y', strtotime($supplier->tanggal_spm) );
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
        return view('supplier.admin.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kode_satker' => 'required|size:6|exists:satkers,kode',
            'kode' => 'required|size:5',
            'nama_supplier' => 'required',
            'tanggal_spm' => 'required|date',
            'nilai_spm' => 'required|numeric',
            'keterangan' => 'required',
            'tanggal_terima' => 'required|date'
            ]);
        $supplier = Supplier::create($request->all());
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan SPM nomor $supplier->kode"
        ]);
        return redirect()->route('supplier.create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.admin.edit')->with(compact('supplier'))->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kode_satker' => 'required|size:6|exists:satkers,kode',
            'kode' => 'required|size:5',
            'tanggal_terima' => 'required|date',
            'nama_supplier' => 'required',
            'tanggal_spm' => 'required|date',
            'nilai_spm' => 'required|numeric',
            'keterangan' => 'required'
          ]);
        $supplier = Supplier::find($id);
        $supplier->update($request->all());
                
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil mengubah SPM nomor $supplier->kode"
        ]);
        return redirect()->route('supplier.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
