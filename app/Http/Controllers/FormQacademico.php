<?php

namespace App\Http\Controllers;

use App\Models\Acao;
use App\Models\ConteudoProgramatico;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FormQacademico extends Controller
{
    public function print($id) {

        $acao = Acao::find($id);

        // ATIVIDADE RELATIVA

        if($acao->atividade_relativa == 1) {
            $atividadeRelativa = 'Ensino';
        } if($acao->atividade_relativa == 2) {
            $atividadeRelativa = 'Pesquisa';
        } if($acao->atividade_relativa == 3) {
            $atividadeRelativa = 'Extensão';
        }

        // DURAÇÃO DA AULA

        if($acao->duracao_aula == 1) {
            $duracaoAula = '45 min';
        } if($acao->duracao_aula == 2) {
            $duracaoAula = '50 min';
        } if($acao->duracao_aula == 3) {
            $duracaoAula = '60 min';
        }

         // MODALIDADE

         if($acao->modalidade == 1) {
            $modalidade = 'Presencial';
        } if($acao->modalidade == 2) {
            $modalidade = 'EAD';
        } if($acao->modalidade == 3) {
            $modalidade = 'Semipresencial';
        }
       
        //TURNO

        if($acao->turno == 1) {
            $turno = 'Matutino';
        } if($acao->turno == 2) {
            $turno = 'Vespertino';
        } if($acao->turno == 3) {
            $turno = 'Noturno/Integral';
        }

         //PERIOCIDADE

         if($acao->periocidade == 1) {
            $periocidade = 'Matutino';
        } if($acao->periocidade == 2) {
            $periocidade = 'Vespertino';
        } if($acao->periocidade == 3) {
            $periocidade = 'Noturno/Integral';
        }

        //APROVAÇÃO

        if($acao->criterio_aprovacao == 1) {
            $aprovacao = 'Somente por frequência';
        } if($acao->criterio_aprovacao == 2) {
            $aprovacao = 'Somente por nota';
        } if($acao->criterio_aprovacao == 3) {
            $aprovacao = 'Frequência e nota';
        }

        //FREQUENCIA MÍNIMA
        
        if($acao->frequencia_minima == 1) {
            $frequencia = '70%';
        }  if($acao->frequencia_minima == 2) {
            $frequencia = '75%';
        }  if($acao->frequencia_minima == 3) {
            $frequencia = '80%';
        }

        //MEDIA DE APROVAÇÃO
        
        if($acao->media_aprovacao == 1) {
            $mediaAprovacao = '6.0';
        }  if($acao->media_aprovacao == 2) {
            $mediaAprovacao = '6.5';
        }  if($acao->media_aprovacao == 3) {
            $mediaAprovacao = '7.0';
        }

     //    $contProg = ConteudoProgramatico::where('acao_id',$id)-;

       //  dd($acao->conteudoProgramatico);

         
       
        return Pdf::loadView('pdf.Form-qacademico', compact(['acao',
                                                            'atividadeRelativa',
                                                            'duracaoAula',
                                                            'modalidade',
                                                            'turno',
                                                            'periocidade',
                                                            'aprovacao',
                                                            'frequencia',
                                                            'mediaAprovacao'


                                                    ]))->stream();

       
    }
}
