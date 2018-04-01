<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    public $table = "satkers";
    
    protected $primaryKey = 'kode';
    
    public $incrementing = false;
    
    protected $fillable = ['kode', 'nama_satker', 'whatsapp'];
    
    public function suppliers (){
        return $this->hasMany('App\Spms');
    }
}