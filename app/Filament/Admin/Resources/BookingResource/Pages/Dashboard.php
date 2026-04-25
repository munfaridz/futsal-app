<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // Mengubah tulisan "Dashboard" di menu samping menjadi lebih umum
    protected static ?string $navigationLabel = 'Panel Utama';

    // Mengubah judul besar di tengah halaman
    protected static ?string $title = 'Sistem Booking GOR Oslo';

    // Mengubah icon menu samping (pake icon rumah)
    protected static ?string $navigationIcon = 'heroicon-o-home';
}