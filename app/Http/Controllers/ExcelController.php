<?php

// Laravel Excel 2.1 https://github.com/Maatwebsite/Laravel-Excel/tree/2.1
// Dokumentasi https://laravel-excel.maatwebsite.nl/docs/2.1/import/basics

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Http\Controllers\QueryRead;
use Illuminate\Support\Facades\DB;

class ExcelController extends Controller
{
    private $orderedArray = [];
    private $loop = true;
    private $i = 0;

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

        $excel = Excel::selectSheetsByIndex(0)->load($file, function($reader) {   // Ubah excel jadi array
        })->takeRows(60)->toArray();

        $tes = $this->bulkInsert($excel);
        print_r($tes);
        die();
    }

    private function bulkInsert($unOrderedArray)
    {
        foreach($unOrderedArray as $key => $value)
        {
            if($this->loop) {
                if(is_array($value)) {
                    // array_push($this->bulkQuery, $value);
                    // Rrrrreecursion kalau ada bug asalnya paling dari sini
                    $this->bulkInsert($value);
                    $this->i++;
                } else {
                    $this->assembleTheArray($key, $value);
                }
            } else {
                return $this->orderedArray;
            }
        }
        return null;
    }

    private function assembleTheArray($key, $value)
    {
        switch($key) {
            case 'no':
                break;
            case 'approver':
                break;
            case 'response':
                break;
            case 'tanggal_penolakan':
                $this->orderedArray[$this->i]['tanggal_terima'] = $value;
                break;
            case 'nomor_invoice':
                if($this->sudahTerinput($value)) {
                    array_pop($this->orderedArray);
                    $this->loop = false;
                    break;
                }
                $this->orderedArray[$this->i]['kode'] = substr($value, 0, 5);
                $this->orderedArray[$this->i]['kode_satker'] = substr($value, 7, 6);
                break;
            case 'tanggal_invoice':
                $this->orderedArray[$this->i]['tanggal_spm'] = $value; break;
            case 'nilai_invoice':
                $this->orderedArray[$this->i]['nilai_spm'] = $value; break;
            case 'alasan_penolakan':
                $this->orderedArray[$this->i]['keterangan'] = $value; break;
        }
    }

    private function sudahTerinput(String $noInvoice)
    {
        // Array index terkecil masuk duluan ke database (LIFO)
        // Ambil nomor spm dari query impor terakhir
        // Bar ngono cocokno neng $noSpm, hasile return bool
        $lastImport = DB::table('spms')->where('import', 1)->latest()->first()->kode; // String nomor spm
        $noSpm = substr($noInvoice, 0, 5);

        return $noSpm === $lastImport;
    }
}
