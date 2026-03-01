<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BookingStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalBookings = Booking::query()->count();
        $pendingBookings = Booking::query()->where('status', 'pending')->count();
        $confirmedBookings = Booking::query()->where('status', 'confirmed')->count();
        $monthlyRevenue = Booking::query()
            ->where('status', 'confirmed')
            ->whereYear('event_date', $currentYear)
            ->whereMonth('event_date', $currentMonth)
            ->sum('total_price');

        return [
            Stat::make('Total Booking', number_format($totalBookings)),
            Stat::make('Pending', number_format($pendingBookings))
                ->color('warning'),
            Stat::make('Confirmed', number_format($confirmedBookings))
                ->color('success'),
            Stat::make('Pendapatan Bulan Ini', 'Rp ' . number_format((float) $monthlyRevenue, 0, ',', '.'))
                ->color('primary'),
        ];
    }
}
