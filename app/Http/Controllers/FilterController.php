<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Satker;
use Validator;
use App\Http\Controllers\DatatablesController as IndexTable;
use App\Http\Controllers\PrefixController as Prefix;
use Yajra\DataTables\Html\Builder;

class FilterController extends Controller
{
    public function filter(Prefix $prefix)
    {
        return view('filter.index')->with('prefix', $prefix->getPrefix());
    }
    
    public function index(Request $request, Builder $htmlBuilder, Prefix $prefix)
    {
        $this->validate($request, [
          'jenis' => 'required'
        ]);
        
        $datatables = new IndexTable($request);

        return $datatables->spm($request, $htmlBuilder, $prefix);
    }    
}