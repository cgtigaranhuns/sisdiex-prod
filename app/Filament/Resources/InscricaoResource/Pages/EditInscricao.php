<?php

namespace App\Filament\Resources\InscricaoResource\Pages;

use App\Filament\Resources\InscricaoResource;
use App\Models\Acao;
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
        $acao = Acao::find($this->data['acao_id']);
        //  dd($this->data['status']);
        if($this->data['status'] == 2)  {          
            Mail::raw('Sua inscrição para o Evento/Ação: '.$acao->titulo.', está confirmada.', function($msg) {
            $msg->to($this->data['email'])->subject('Inscrição confirmada'); 
            
            }); 
        }elseif($this->data['status'] == 3)  {          
            Mail::raw('Sua inscrição para o Evento/Ação: '.$acao->titulo.', foi recusada. Entre em contato com a Divisão de 
            Extensão (DIEX), para mais informações. Email: diex@garanhuns.ifpe.edu.br', function($msg) {
            $msg->to($this->data['email'])->subject('Inscrição recusada');  
       
            }); 
        }
    }
}
