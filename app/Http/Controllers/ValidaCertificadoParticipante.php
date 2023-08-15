<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscricao;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ValidaCertificadoParticipante extends Controller

{

    public function index() {
        
        return view('ValidaCertificado.Index-participante');
    }

    public function validar(Request $request) {

       
      
                $codigo = $request->input('codigo');
                $inscricao = Inscricao::where('certificado_cod','=',$codigo)->first();

             if($inscricao) {                  
                if($inscricao->inscricao_tipo == 1) {
                    $nome = $inscricao->discente->name;
                }if($inscricao->inscricao_tipo == 2) {
                    $nome = $inscricao->user->name; 
                }if($inscricao->inscricao_tipó == 3) {
                    $nome = $inscricao->nome;
                }
             
                 return Pdf::loadView('pdf.ValidaCertificadoParticipante', compact(['inscricao','nome']))->stream();
            }
            return view('ValidaCertificado.erro');
        }
         

        
     
}
