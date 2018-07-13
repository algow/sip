<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Spm;
use App\Satker;

class AjaxController extends Controller
{
    public function ajax()	// Cari nama Satker berdasarkan kode Satker
    {
        $id = htmlentities(strip_tags(trim($_GET['kode'])));

        $namaSatker = Satker::select('nama_satker','kode')->where('kode', $id)->get();
        return response()->json($namaSatker);
    }
}
