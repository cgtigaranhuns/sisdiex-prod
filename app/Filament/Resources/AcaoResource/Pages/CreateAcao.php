<?php

namespace App\Filament\Resources\AcaoResource\Pages;

use App\Filament\Resources\AcaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateAcao extends CreateRecord



{
    protected static string $resource = AcaoResource::class;

    protected static ?string $title = 'Criar proposta de evento/ação';

    protected function afterCreate(): void
    {
      //  dd($this->record->user->name);
                    
        Mail::raw('Olá '.$this->record->user->name.', sua proposta para o Evento/Ação: '.$this->data['titulo'].', está em análise.', function($msg) {
            $msg->to(auth()->user()->email)->subject('Proposta em análise'); 
        }); 

        Mail::raw('Uma proposta de '.$this->record->user->name.' para Evento/Ação: '.$this->data['titulo'].', foi cadastrada.', function($msg) {
            $msg->to('wellington.cavalcante@garanhuns.ifpe.edu.br')->subject('Proposta cadastrada'); 
          
        }); 
    }
}
