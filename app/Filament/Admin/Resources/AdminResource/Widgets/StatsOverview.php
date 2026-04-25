<?php

namespace App\Filament\StatsOverview;

use App\Models\Booking;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    // Mengatur agar widget ini muncul paling atas
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Hitung total uang masuk dari tabel booking column 'total_harga'
        $totalPendapatan = Booking::sum('total_harga');

        return [
            // Kotak 1: Total Booking yang sudah dibuat
            Stat::make('Total Booking', Booking::count())
                ->description('Jumlah jadwal terisi')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),

            // Kotak 2: Total Uang Masuk
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Uang masuk dari penyewaan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            // Kotak 3: Jumlah User (Pelanggan)
            Stat::make('Jumlah Pelanggan', User::where('email', '!=', 'admin@gmail.com')->count())
                ->description('User terdaftar (non-admin)')
                ->descriptionIcon('heroicon-m-users')
                ->color('warning'),
        ];
    }
}