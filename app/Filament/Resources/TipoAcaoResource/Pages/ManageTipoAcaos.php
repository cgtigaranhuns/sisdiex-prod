<?php

namespace App\Filament\Resources\TipoAcaoResource\Pages;

use App\Filament\Resources\TipoAcaoResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTipoAcaos extends ManageRecords
{
    protected static string $resource = TipoAcaoResource::class;

    protected static ?string $title = 'Tipo Ações';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo Tipo Ação'),
        ];
    }
}
