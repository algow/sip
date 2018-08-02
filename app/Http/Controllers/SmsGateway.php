<?php

namespace App\Http\Controllers;
use App\Satker;

use Illuminate\Http\Request;

class SmsGateway
{
    private $kontak;
    private $jenis;
    private $nomor;
    private $tanggal;
    private $keterangan;

    public function __construct($content)
    {
        $this->kontak = $content['whatsapp'];
        $this->jenis = $content['jenis'];
        $this->nomor = $content['kode'];
        $this->tanggal = $content['tanggal_terima'];
        $this->keterangan = $content['keterangan'];
    }

    public function send()
    {
        $content = [$this->kontak, $this->jenis, $this->nomor, $this->tanggal, $this->keterangan];
        $contentJson = '"' . addslashes(json_encode($content)) . '"';
        print_r($contentJson);
        die();
        $execPy = "python ../sms-py/send.py $contentJson >/dev/null 2>/dev/null &";
        exec($execPy);
    }
}
