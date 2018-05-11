<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsGateway extends Controller
{
    protected $jenis;
    protected $nomor;
    protected $tanggal;
    protected $keterangan;

    public function __construct($content)
    {
        $this->jenis = $content->jenis;
        $this->nomor = $content->kode;
        $this->tanggal = $content->tanggal_terima;
        $this->keterangan = $content->keterangan;
    }

    public function send()
    {
        $content = array($this->jenis, $this->nomor, $this->tanggal, $this->keterangan);
        $contentJson = json_encode($content);

        $test = "python ../sms-py/sms.py $contentJson";

        exec($test, $print);
        var_dump($print);
        die();
    }
}
