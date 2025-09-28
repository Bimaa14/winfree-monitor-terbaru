<?php

namespace App\Filament\Widgets;

use App\Models\Site;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSiteUpdates extends BaseWidget
{
    // PENTING: Menambahkan listener agar widget ini ikut ter-update saat tombol refresh ditekan
    protected $listeners = ['refresh-widgets' => '$refresh'];

    protected static ?string $heading = 'Aktivitas Site Terkini';

    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Site::query()
                    ->latest('updated_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Site')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->trueColor('success')
                    ->falseIcon('heroicon-o-x-circle')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Update')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ]);
    }
}

