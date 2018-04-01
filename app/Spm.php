<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spm extends Model
{
    protected $fillable = ['kode', 'nama_supplier', 'tanggal_spm', 'tanggal_terima', 'nilai_spm', 'keterangan', 'tanda_terima', 'diambil_pada', 'kode_satker','pengambil', 'jenis'];

    public function satker () {
        return $this->belongsTo('App\Satker');
    }
}