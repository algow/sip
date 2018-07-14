<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Http\Controllers\QueryRead;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    private $bulkQuery = [];
    private $loop = true;

    private function query($request)
    {
        $query = new QueryRead($request);

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
                            strtoupper($spm->keterangan),
                            $spm->diambil_pada
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
                            strtoupper($spm->keterangan),
                            $spm->diambil_pada
                        ]);
                    }
                }
            });
        })->export('xlsx');
    }

    public function importSpm(Request $request)
    {
        $file = $request->file('import');

        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) {
        })->get()->toArray();

        $this->bulkInsert($excel);
    }
    private function bulkInsert($data)
    {
        foreach($data as $key => $value)
        {
            if($this->loop) {
                if(is_array($value)) {
                    array_push($this->bulkQuery, $value);
                    // Rrrreecursion AWAS BUG
                    $this->bulkInsert($value);
                } elseif($key === 'nomor_invoice' && $this->sudahTerinput($value)) {
                    array_pop($this->bulkQuery);
                    $this->loop = false;
                }
            } else {
                return $this->bulkQuery;
            }
        }
    }

    private function sudahTerinput($nomSpm)
    {
        // array[0] masuk id database kecil
        // Ambil nomor spm dari query terakhir
        // Bar ngono cocokno neng $noSpm, hasile return bool
        $lastImport = DB::table('spms')->where('import', 1)->latest()->first();
        return $nomSpm === $lastImport;
    }
}
