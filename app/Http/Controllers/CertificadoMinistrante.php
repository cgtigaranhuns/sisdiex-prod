<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\ConteudoProgramatico;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoMinistrante extends Controller
{
    public function print($id) {

        $cp = ConteudoProgramatico::find($id);

        //Nome do Inscrito

        
     //   $contProg = $acao->ConteudoProgramatico;
       
       

        return Pdf::loadView('pdf.CertificadoMinistrante', compact(['cp']))->setPaper('A4', 'landscape')->stream();
    }
}
