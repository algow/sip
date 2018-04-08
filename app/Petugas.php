<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $fillable = ['nama_petugas'];
    
    protected $primaryKey = 'barcode';
    
    public $incrementing = false;
    
    public function spm () {
        return $this->hasMany('App\Spm');
    }
    
    public function satker () {
        return $this->belongsTo('App\Satker', 'kode_satker');
    }
}