<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MembershipResource\Pages;
use App\Filament\Admin\Resources\MembershipResource\RelationManagers;
use App\Models\Membership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function form(Form $form): Form
{
    return $form
->schema([
            // GANTI Pilih Pelanggan (User) menjadi Pilih Tim dari Booking
            \Filament\Forms\Components\Select::make('nama_tim') // Kita simpan nama timnya
                ->label('Pilih Tim Futsal')
                ->options(
                    // Mengambil daftar nama tim unik dari tabel bookings
                    \App\Models\Booking::query()
                        ->pluck('nama_tim', 'nama_tim')
                        ->toArray()
                )
                ->searchable()
                ->required(),   
            \Filament\Forms\Components\TextInput::make('level')
                ->placeholder('Contoh: Gold, Silver, Bronze')
                ->required(),
            \Filament\Forms\Components\DatePicker::make('expiry_date')
                ->label('Berlaku Sampai')
                ->required(),
            \Filament\Forms\Components\TextInput::make('discount_rate')
                ->label('Diskon (%)')
                ->numeric()
                ->suffix('%')
                ->required(),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Pakai TextColumn, JANGAN pakai Select::make di sini
            Tables\Columns\TextColumn::make('user.name')
                ->label('Nama Member')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('level')
                ->badge()
                ->color('success'),

            Tables\Columns\TextColumn::make('expiry_date')
                ->label('Masa Berlaku')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('discount_rate')
                ->label('Diskon')
                ->suffix('%'),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
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
            'index' => Pages\ListMemberships::route('/'),
            'create' => Pages\CreateMembership::route('/create'),
            'edit' => Pages\EditMembership::route('/{record}/edit'),
        ];
    }
}
