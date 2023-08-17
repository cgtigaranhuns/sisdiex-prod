<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\ConteudoProgramatico;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ValidaCertificadoMinistrante extends Controller
{
    public function index() {
        
        return view('ValidaCertificado.Index-ministrante');
    }

    public function validar(Request $request) {

        $codigo = $request->input('codigo');
        $cp = ConteudoProgramatico::where('certificado_cod','=',$codigo)->first();

        $acao = Acao::find($cp->acao_id);

        return Pdf::loadView('pdf.ValidaCertificadoMinistrante', compact(['cp','acao']))->stream();
    

    return view('ValidaCertificado.erro');
}

}
