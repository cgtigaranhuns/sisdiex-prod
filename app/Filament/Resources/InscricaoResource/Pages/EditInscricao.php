<?php

namespace App\Filament\Resources\InscricaoResource\Pages;

use App\Filament\Resources\InscricaoResource;
use App\Models\Acao;
use App\Models\Inscricao;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditInscricao extends EditRecord
{
    protected static string $resource = InscricaoResource::class;

    

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            
        ];
    }

    protected function beforeSave(): void
    {
        //TIPO DE INSCRITO
               
        if($this->record->inscricao_tipo == 1){
            $nomeInscrito = $this->record->discente->name;
        }
        if($this->record->inscricao_tipo == 2){
            $nomeInscrito = $this->record->user->name;
        }
        if($this->record->inscricao_tipo == 3){
            $nomeInscrito = $this->record->nome;
        }

        //TIPO DE REPROVAÇÃO

        if($this->data['motivo_reprovacao'] == 1){
            $motivoReprovacao = 'Falta';
        }
        if($this->data['motivo_reprovacao'] == 2){
            $motivoReprovacao = 'Não Aproveitamento';
        }
        if($this->data['motivo_reprovacao'] == 3){
            $motivoReprovacao = 'Desistência';
        }
        if($this->data['motivo_reprovacao'] == 4){
            $motivoReprovacao = 'Evasão';
        }

        $acao = Acao::find($this->data['acao_id']);
        //  dd($this->data['status']);
        if($this->data['motivo_reprovacao'] <> '')  {          
            Mail::raw('Olá,'.$nomeInscrito.', sua participação no Evento/Ação: '.$acao->titulo.',  não houve aproveitamento satisfatório, pelo motivo de: '. $motivoReprovacao.'. Em caso de dúvidas, entre em contato com a Divisão de Extensão (DIEX), para mais informações. Email: diex@garanhuns.ifpe.edu.br.', function($msg) {
            $msg->to($this->data['email'])->subject('Certificado não liberado'); 
            
        }); 
        
        }
    }
}
