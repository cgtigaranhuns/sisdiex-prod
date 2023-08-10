<?php

namespace App\Filament\Resources\AcaoResource\Pages;

use App\Filament\Resources\AcaoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcao extends EditRecord
{
    protected static string $resource = AcaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
