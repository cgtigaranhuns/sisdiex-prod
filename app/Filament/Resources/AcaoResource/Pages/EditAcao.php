<?php

namespace App\Filament\Resources\AcaoResource\Pages;

use App\Filament\Resources\AcaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditAcao extends EditRecord
{
    protected static string $resource = AcaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
      //  dd($this->data['status']);
        if($this->data['status'] == 2)  {          
            Mail::raw('Olá '.$this->record->user->name.', sua proposta para o Evento/Ação: '.$this->data['titulo'].', foi aprovada.', function($msg) {
            $msg->to([auth()->user()->email, 'diex@garanhuns.ifpe.edu.br'])->subject('Proposta aprovada'); 
            
            }); 
        }elseif($this->data['status'] == 3)  {          
            Mail::raw('Olá '.$this->record->user->name.', sua proposta para o Evento/Ação: '.$this->data['titulo'].', foi recusada, pelo motivo: '.$this->data['status_justifique'].'', function($msg) {
            $msg->to([auth()->user()->email, 'diex@garanhuns.ifpe.edu.br'])->subject('Proposta recusada'); 
       
            }); 
        }
    }
}
