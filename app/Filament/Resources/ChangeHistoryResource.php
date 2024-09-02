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

class ChangeHistoryResource extends Resource
{
    protected static ?string $model = ChangeHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Changed At')
                    ->sortable(),
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
                TextColumn::make('change_location')
                    ->label('Change Location')
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
            'create' => Pages\CreateChangeHistory::route('/create'),
            'edit' => Pages\EditChangeHistory::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
