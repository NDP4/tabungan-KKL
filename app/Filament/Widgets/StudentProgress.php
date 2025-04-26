<?php

namespace App\Filament\Widgets;

use App\Services\ChartDataService;
use Filament\Widgets\ChartWidget;

class StudentProgress extends ChartWidget
{
    protected static ?string $heading = 'Progress Tabungan per Mahasiswa';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $chartData = app(ChartDataService::class)->getProgressByStudent();

        return [
            'datasets' => [
                [
                    'label' => 'Progress (%)',
                    'data' => $chartData['values'],
                    'backgroundColor' => array_fill(0, count($chartData['values']), 'rgb(79, 70, 229)'),
                ]
            ],
            'labels' => $chartData['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'ticks' => [
                        'callback' => 'function(value) { return value + "%"; }',
                    ],
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.parsed.y.toFixed(1) + "%"; }',
                    ],
                ],
            ],
        ];
    }
}
