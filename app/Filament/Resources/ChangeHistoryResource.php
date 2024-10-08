<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChangeHistoryResource\Pages;
use App\Filament\Resources\ChangeHistoryResource\RelationManagers;
use App\Models\ChangeHistory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class ChangeHistoryResource extends Resource
{
    protected static ?string $model = ChangeHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('link.url')
                    ->label('Link URL')
                    ->searchable()
                    ->sortable()->limit(50),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),
                IconColumn::make('is_changed')
                    ->label('Changed')
                    ->boolean() 
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle') 
                    ->falseIcon('heroicon-o-x-circle')
                    ->alignment('center'),
                TextColumn::make('old_content')
                    ->label('Old Content')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('new_content')
                    ->label('New Content')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('name')
                    ->label('User Name'),
                TextColumn::make('user_id')
                    ->label('User ID'),
            ])
            ->filters([
                // You can define filters here
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('link.url')
                    ->label('Link URL')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Changed At')
                    ->dateTime()
                    ->columnSpanFull(),
                TextEntry::make('name')
                    ->label('User Name')
                    ->columnSpanFull(),
                TextEntry::make('user_id')
                    ->label('User ID')
                    ->columnSpanFull(),
                TextEntry::make('old_content')
                    ->label('Old Content')
                    ->columnSpanFull(),
                TextEntry::make('new_content')
                    ->label('New Content')
                    ->columnSpanFull(),
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
            'index' => Pages\ListChangeHistories::route('/'),
            'view' => Pages\ViewChangeHistory::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
