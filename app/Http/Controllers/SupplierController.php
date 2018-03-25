<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Yajra\DataTables\DataTables;
use App\Supplier;
use Validator;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\DatatablesController as IndexTable;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->away('http://localhost/sipen/public/admin/telusuri?jenis=supplier&satker=&tanggal=');
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
