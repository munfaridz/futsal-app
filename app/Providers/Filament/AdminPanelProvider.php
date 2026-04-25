<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\HtmlString; // Tambahkan import ini

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('GOR Futsal Pria Oslo')
            ->colors([
                'primary' => \Filament\Support\Colors\Color::Indigo,
                'gray' => \Filament\Support\Colors\Color::Zinc,
            ])
            ->font('Poppins')
            ->darkMode(true)
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class, // Sudah dimatikan
            ])

            // --- CSS CUSTOM UNTUK BACKGROUND GAMBAR ---
// Tambahkan di dalam renderHook panels::body.start yang tadi sudah kita buat

// Tambahkan/Update di dalam AdminPanelProvider.php pada bagian renderHook

->renderHook(
    'panels::body.start',
    fn () => new HtmlString("
        <style>
            /* Mengatur Background Halaman Login secara keseluruhan */
            .fi-simple-layout {
                background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/images/bg-futsal.jpg');
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }

            /* MEMBUAT KOTAK LOGIN TRANSPARAN (GLASSMORPHISM) */
            .fi-simple-main {
                background-color: rgba(255, 255, 255, 0.08) !important; /* Transparansi Putih */
                backdrop-filter: blur(12px) saturate(180%); /* Efek Blur Kaca */
                -webkit-backdrop-filter: blur(12px) saturate(180%);
                border: 1px solid rgba(255, 255, 255, 0.2); /* Garis tepi tipis agar elegan */
                border-radius: 24px !important;
                box-shadow: 0 10px 40px 0 rgba(0, 0, 0, 0.5); /* Bayangan agar lebih berdimensi */
            }

            /* Memastikan Card di dalamnya juga transparan */
            .fi-simple-main > div {
                background-color: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }

            /* Warna Teks agar tetap kontras di atas background gelap */
            .fi-simple-main h1, 
            .fi-simple-main p, 
            .fi-simple-main label,
            .fi-simple-main span {
                color: white !important;
            }

            /* Input Field agar sedikit transparan juga (Opsional) */
            .fi-simple-main input {
                background-color: rgba(255, 255, 255, 0.9) !important;
                color: black !important;
                border-radius: 12px !important;
            }
        </style>
    ")
)
            // ------------------------------------------

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}