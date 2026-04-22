<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Filament\Admin\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable(),
                
                Forms\Components\TextInput::make('nama_tim')
                    ->required(),
                
                Forms\Components\Select::make('lapangan')
                    ->options([
                        'Sintetis' => 'Sintetis',
                        'Vinyl' => 'Vinyl',
                        'Parquet' => 'Parquet',
                    ])->required(),
                
                Forms\Components\DatePicker::make('tanggal')
                    ->required(),

                Forms\Components\TimePicker::make('jam_mulai')
                    ->required()
                    ->rules([
                        fn (Forms\Get $get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                            $exists = \App\Models\Booking::where('tanggal', $get('tanggal'))
                                ->where('lapangan', $get('lapangan'))
                                ->where('jam_mulai', $value)
                                ->exists();

                            if ($exists) {
                                $fail('Jadwal lapangan ini sudah dipesan orang lain pada tanggal tersebut.');
                            }
                        },
                    ]),
                
                Forms\Components\TextInput::make('durasi')
                    ->numeric()
                    ->suffix('Jam')
                    ->required(),
                
                Forms\Components\TextInput::make('total_harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('lapangan')
                        ->weight('bold')
                        ->size('lg')
                        ->icon('heroicon-m-trophy'),
                    Tables\Columns\TextColumn::make('nama_tim')
                        ->color('gray'),
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('tanggal')
                            ->date('d M Y')
                            ->icon('heroicon-m-calendar'),
                        Tables\Columns\TextColumn::make('jam_mulai')
                            ->icon('heroicon-m-clock'),
                    ]),
                    
                    // BAGIAN HARGA DITAMBAHKAN DI SINI (Dalam Split agar sejajar)
                    Tables\Columns\Layout\Split::make([
                        Tables\Columns\TextColumn::make('durasi')
                            ->suffix(' Jam Penyewaan')
                            ->color('primary'),
                        
                        Tables\Columns\TextColumn::make('total_harga')
                            ->money('IDR') // Format Rupiah otomatis
                            ->weight('bold')
                            ->color('success') // Warna hijau agar kontras
                            ->alignEnd(),
                    ])->extraAttributes(['class' => 'border-t border-blue-100 pt-2 mt-2']),

                ])->space(3)
                ->extraAttributes([
                    'class' => 'bg-white border-2 border-blue-50 rounded-2xl shadow-sm hover:border-blue-400 hover:shadow-lg transition-all p-5',
                    'style' => 'border-top: 6px solid #2563eb;', 
                ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->button()->color('info'),
                Tables\Actions\DeleteAction::make()->button(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->email !== 'admin@gmail.com') {
            return parent::getEloquentQuery()->where('user_id', auth()->id());
        }
        
        return parent::getEloquentQuery();
    }
}