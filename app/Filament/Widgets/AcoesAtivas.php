<?php

namespace App\Filament\Widgets;

use App\Models\Acao;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AcoesAtivas extends BaseWidget
{

    public static function canView(): bool
    {

        /** @var \App\Models\User */
        $authUser =  auth()->user();

        if ($authUser->hasRole('Administrador')) {
            return true;
        } else {
            return false;
        }
    }


    protected static ?string $heading = 'Ações/Eventos Ativos';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');

        $hoje = date('Y-m-d');

        return $table
            ->query(
                Acao::query()->where('status', 2)->where('data_inicio_inscricoes', '<=', $hoje)->where('data_encerramento', '>=', $hoje)->orderby('data_encerramento', 'asc'),
            )
            ->columns([
                Tables\Columns\TextColumn::make('titulo'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Proponente'),
                Tables\Columns\TextColumn::make('Inscrições_analise')
                    ->label('Inscrições Pendentes')
                    ->alignCenter()
                    ->default(function (Acao $acao) {
                        return $acao->Inscricao->where('inscricao_status', 1)->count();
                    }),
                Tables\Columns\TextColumn::make('Inscrições_efetivada')
                    ->label('Inscrições Efetivadas')
                    ->alignCenter()
                    ->default(function (Acao $acao) {
                        return $acao->Inscricao->where('inscricao_status', 2)->count();
                    }),
                Tables\Columns\TextColumn::make('Inscrições_recusadas')
                    ->label('Inscrições Recusadas')
                    ->alignCenter()
                    ->default(function (Acao $acao) {
                        return $acao->Inscricao->where('inscricao_status', 3)->count();
                    }),

            ]);
    }
}
