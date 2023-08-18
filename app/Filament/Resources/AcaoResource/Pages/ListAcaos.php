<?php

namespace App\Filament\Resources\AcaoResource\Pages;

use App\Filament\Resources\AcaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcaos extends ListRecords
{
    protected static string $resource = AcaoResource::class;

    protected static ?string $title = 'Propostas de Ação/Evento';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nova Proposta'),
        ];
    }

    
}
