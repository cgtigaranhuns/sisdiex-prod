<?php

namespace App\Filament\Widgets;

use App\Models\Inscricao;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class InscricoesMensal extends ChartWidget
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

    protected static ?string $heading = 'Inscrições';

    protected function getData(): array
    {
        $data = Trend::model(Inscricao::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Inscrições por Mês',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
