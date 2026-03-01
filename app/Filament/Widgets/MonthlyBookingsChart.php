<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\ChartWidget;

class MonthlyBookingsChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Booking Bulanan';

    protected function getData(): array
    {
        $year = now()->year;

        $allBookings = Booking::query()
            ->selectRaw('MONTH(event_date) as month, COUNT(*) as total')
            ->whereYear('event_date', $year)
            ->groupByRaw('MONTH(event_date)')
            ->pluck('total', 'month');

        $confirmedBookings = Booking::query()
            ->selectRaw('MONTH(event_date) as month, COUNT(*) as total')
            ->whereYear('event_date', $year)
            ->where('status', 'confirmed')
            ->groupByRaw('MONTH(event_date)')
            ->pluck('total', 'month');

        $labels = [];
        $bookingSeries = [];
        $confirmedSeries = [];

        for ($month = 1; $month <= 12; $month++) {
            $labels[] = now()->startOfYear()->addMonths($month - 1)->translatedFormat('M');
            $bookingSeries[] = (int) ($allBookings[$month] ?? 0);
            $confirmedSeries[] = (int) ($confirmedBookings[$month] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Booking',
                    'data' => $bookingSeries,
                ],
                [
                    'label' => 'Confirmed',
                    'data' => $confirmedSeries,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
