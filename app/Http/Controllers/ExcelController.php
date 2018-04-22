<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Http\Controllers\QueryController as QueryController;

class ExcelController extends Controller
{
    public function query($request)
    {
        $query = new QueryController($request);
        
        return $query;
    }

    public function exportSpm(Request $request)
    {
        $query = $this->query($request)->getQuery();
        $tanggal_terima = $this->query($request)->getTanggal();
        $jenis = $this->query($request)->getJenis();
        
        $spm = array($query, $tanggal_terima, $jenis);

        Excel::load('misc/' . $jenis . '.xlsx', function($excel) use ($spm) {
            $excel->sheet('Sheet1', function($sheet) use ($spm) {
                $sheet->setCellValue('C2', $spm[1]);
                $i = 1;
                $rows = 3;
                
                if($spm[2] == 'spm')
                {
                    foreach ($spm[0] as $spm) {
                        $sheet->prependRow(++$rows, [
                            $i++,
                            $spm->kode_satker,
                            strtoupper($spm->nama_supplier),
                            $spm->kode,
                            date('d/m/Y', strtotime($spm->tanggal_spm)),
                            number_format($spm->nilai_spm, 0, '.', '.'),
                            strtoupper($spm->keterangan)
                        ]);
                    } 
                }
                else
                {
                    foreach ($spm[0] as $spm) {
                        $sheet->prependRow(++$rows, [
                            $i++,
                            $spm->kode_satker,
                            strtoupper($spm->nama_supplier),
                            $spm->kode,
                            number_format($spm->nilai_spm, 0, '.', '.'),
                            strtoupper($spm->keterangan)
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }
}