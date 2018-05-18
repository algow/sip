<?php

namespace App\Http\Controllers;
use App\Satker;

use Illuminate\Http\Request;

class SmsGateway extends Controller
{
    protected $kontak;
    protected $jenis;
    protected $nomor;
    protected $tanggal;
    protected $keterangan;

    public function __construct($content)
    {
        $this->kontak = $content->satker->whatsapp;
        $this->jenis = $content->jenis;
        $this->nomor = $content->kode;
        $this->tanggal = $content->tanggal_terima;
        $this->keterangan = $content->keterangan;
    }

    public function send()
    {
        $content = array($this->kontak, $this->jenis, $this->nomor, $this->tanggal, $this->keterangan);
        $contentJson = '"' . addslashes(json_encode($content)) . '"';
        print_r($contentJson);
        die();

        $execPy = "python ../sms-py/send.py $contentJson";
        exec($execPy);
    }
}
