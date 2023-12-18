<?php

namespace App\Filament\Widgets;

use App\Models\Acao;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class AcoesMensal extends ChartWidget
{
    protected static ?string $heading = 'Eventos/Ação';

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

    protected function getData(): array
    {
        $data = Trend::model(Acao::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Eventos/Ação por Mês',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
