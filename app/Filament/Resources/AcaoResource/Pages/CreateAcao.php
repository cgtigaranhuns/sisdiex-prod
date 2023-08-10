<?php

namespace App\Filament\Resources\AcaoResource\Pages;

use App\Filament\Resources\AcaoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAcao extends CreateRecord



{
    protected static string $resource = AcaoResource::class;

    protected static ?string $title = 'Criar proposta de evento/ação';
}
