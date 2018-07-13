<?php

namespace App\Http\Controllers;

// Pake package enih github.com/ConsoleTVs/Charts, pake versi 5
// Punya dua anak, Harian & Jenis

use App\Spm;

class Chart
{
    protected $query;

    public function __construct()
    {
        $this->query = Spm::all();
    }
}
