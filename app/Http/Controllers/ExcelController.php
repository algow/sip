<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use App\Supplier;
use App\Kontrak;
use App\Satker;
use App\Http\Controllers\QueryController as QueryController;

class ExcelController extends Controller
{
    public function query($request)
    {
        $query = new QueryController($request);
        return $query->getQuery();
    }
    public function tanggal($request)
    {
        $query = new QueryController($request);
        return $query->getTanggal();
    }
    public function exportSupplier(Request $request)
    {
        $supplier = $this->query($request);
        $tanggal_terima = $this->tanggal($request);
        
        Excel::load('misc\Supplier.xlsx', function($excel) use ($supplier, $tanggal_terima) {
            $excel->sheet('Sheet1', function($sheet) use ($supplier, $tanggal_terima) {
                $sheet->setCellValue('C2', $tanggal_terima);
                $i = 1;
                $rows = 3;
                foreach ($supplier as $suppliers) {
                    $sheet->prependRow(++$rows, [
                        $i++,
                        $suppliers->kode_satker,
                        $suppliers->nama_supplier,
                        $suppliers->kode,
                        date('d/m/Y', strtotime($suppliers->tanggal_spm)),
                        number_format($suppliers->nilai_spm, 0, '.', '.'),
                        $suppliers->keterangan
                    ]);
                } 
            });
        })->export('xlsx');
    }
    public function exportKontrak(Request $request)
    {
        $kontrak = $this->query($request);
        $tanggal_terima = $this->tanggal($request);
                
        Excel::load('misc\Kontrak.xlsx', function($excel) use ($kontrak, $tanggal_terima) {
            $excel->sheet('Sheet1', function($sheet) use ($kontrak, $tanggal_terima) {
                $sheet->setCellValue('C2', $tanggal_terima);
                $i = 1;
                $rows = 3;
                foreach ($kontrak as $kontrak) {
                    $sheet->prependRow(++$rows, [
                        $i++,
                        $kontrak->kode_satker,
                        $kontrak->nama_supplier,
                        $kontrak->kode,
                        number_format($kontrak->nilai_kontrak, 0, '.', '.'),
                        $kontrak->keterangan
                    ]);
                } 
            });
        })->export('xlsx');
    }
    
    public function importExcel(Request $request) 
    { 
        $this->validate($request, [ 'excel' => 'required|mimes:xls,xlsx' ]);
        $excel = $request->file('excel');
        $excels = Excel::selectSheetsByIndex(0)->load($excel, function($reader) {
            // options, jika ada
        })->get();
        
        $rowRules = [
            'kode_satker' => 'required|size:6|exists:satkers,kode',
            'kode' => 'required|size:5',
            'nama_supplier' => 'required',
            'tanggal_spm' => 'required|date',
            'nilai_spm' => 'required|integer',
            'keterangan' => 'required',
        ];
        
        $suppplier_id = [];
        
        foreach ($excels as $row) {
            $validator = Validator::make($row->toArray(), $rowRules);
            if ($validator->fails()) continue;
            $satker = Satker::where('kode', $row['kode_satker'])->first();
            
            if (!$satker) {
                $satker = Satker::create(['kode'=>$row['kode_satker']]);
            }
            
            $supplier = Supplier::create([
                'kode_satker' => $row['kodesatker'],
                'kode' => $row['kode'],
                'nama_supplier' => $row['nama_supplier'],
                'tanggal_spm' => $row['tanggal_spm'],
                'nilai_spm' => $row['nilai_spm'],
                'keterangan' => $row['keterangan'],
            ]);
            
            array_push($supplier_id, $supplier->id);
        }
        return redirect()->route('supplier.admin.index');
    }
}