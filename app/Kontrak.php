<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $fillable = ['kode', 'nama_supplier', 'tanggal_terima_fo', 'nilai_kontrak', 'keterangan', 'tanda_terima', 'diambil_pada', 'kode_satker'];

    public function satker () {
        return $this->belongsTo('App\Satker');
    }
}