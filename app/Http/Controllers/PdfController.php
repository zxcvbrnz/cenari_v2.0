<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PdfController extends Controller
{
    public function GeneratePDF($id)
    {
        $data = Peserta::findOrFail($id);
        $pdf = PDF::loadView('tespdf', [
            'peserta' => $data
        ]);

        return $pdf->download('Data Peserta ' . $data->user->name . '.pdf');
        // return view('tespdf', [
        //     'peserta' => $data
        // ]);
    }
}
