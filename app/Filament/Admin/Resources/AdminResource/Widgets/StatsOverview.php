<?php

use App\Models\Booking;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Booking', Booking::count())
                ->description('Semua pesanan lapangan')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
            Stat::make('Total Lapangan', '3')
                ->description('Sintetis, Vinyl, Parquet')
                ->color('info'),
            Stat::make('User Terdaftar', User::count())
                ->description('Jumlah admin/user')
                ->descriptionIcon('heroicon-m-user')
                ->color('warning'),
        ];
    }
}
