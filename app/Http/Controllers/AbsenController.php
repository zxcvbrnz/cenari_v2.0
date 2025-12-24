<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absen;


class AbsenController extends Controller
{
    //
    public function absen()
    {
        $permohonanan = Absen::where('status', 0);
        $jadwal = Absen::where('status', 1);
        $absen = Absen::where('status', 2);
        $tertolak = Absen::where('status', 3);
        return view('');
    }
}
