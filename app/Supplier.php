<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['kode', 'nama_supplier', 'tanggal_spm', 'tanggal_terima', 'nilai_spm', 'keterangan', 'tanda_terima', 'diambil_pada', 'kode_satker'];

    public function satker () {
        return $this->belongsTo('App\Satker');
    }
}