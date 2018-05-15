<?php

namespace App\Http\Controllers;
use App\Satker;

use Illuminate\Http\Request;

class SmsGateway extends Controller
{
    protected $satker;
    protected $jenis;
    protected $nomor;
    protected $tanggal;
    protected $keterangan;

    public function __construct($content)
    {
        $this->satker = $content->load('satker');
        $this->jenis = $content->jenis;
        $this->nomor = $content->kode;
        $this->tanggal = $content->tanggal_terima;
        $this->keterangan = $content->keterangan;
    }

    public function send()
    {
        $kontak = $this->satker->satker->whatsapp;
        $content = array($kontak, $this->jenis, $this->nomor, $this->tanggal, $this->keterangan);
        $contentJson = '"' . addslashes(json_encode($content)) . '"';
        print_r($contentJson);
        die();
        $execPy = "python ../sms-py/sms.py $contentJson";

        exec($execPy, $dump);
        var_dump($dump);
        die();
    }
}
