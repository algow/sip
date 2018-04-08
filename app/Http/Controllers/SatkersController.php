<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Satker;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTables;
use Validator;

class SatkersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $query_satker = Satker::select(['kode', 'nama_satker', 'whatsapp']);
            return Datatables::of($query_satker)
                ->addColumn('action', function($satker){
                    return view('datatable._aksi')
                        ->with('edit_url', route('satker.edit', $satker->kode))
                        ->with('kontak', route('spm.whatsapp', $satker->kode))
                        ->with('tanggal', 'I think therefore i am')
                        ->with('prefix', 'admin')
                        ->with('pengambil', 'null')
                        ->with('id', $satker->kode);
            })->make(true);
        }
        $html = $htmlBuilder
         ->addColumn(['data' => 'kode', 'name'=>'kode', 'title'=>'Kode Satker'])       
         ->addColumn(['data' => 'nama_satker', 'name'=>'nama_satker', 'title'=>'Nama Satker'])
         ->addColumn(['data' => 'whatsapp', 'name'=>'whatsapp', 'title'=>'Nomor Kontak'])
         ->addColumn(['data' => 'action', 'name'=>'aksi', 'title'=>'Aksi', 'orderable'=>false, 'searchable'=>false]);
        return view('satker.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('satker.create');
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
            'kode' => 'required|unique:satkers,kode|size:6',
            'nama_satker' => 'required|unique:satkers,nama_satker']);
        $satker = Satker::create($request->all());
        return redirect()->route('satker.index');
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
        $satker = Satker::find($id);
        return view('satker.edit')->with(compact('satker'))->with('id', $id);
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
            'kode' => 'required|size:6|exists:satkers,kode',
            'nama_satker' => 'required']);
        $satker = Satker::find($id);
        $satker->update($request->all());
        return redirect()->route('satker.index');        
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
