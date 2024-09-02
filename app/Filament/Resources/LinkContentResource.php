<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkContentResource\Pages;
use App\Filament\Resources\LinkContentResource\RelationManagers;
use App\Models\LinkContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class LinkContentResource extends Resource
{
    protected static ?string $model = LinkContent::class;

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
                    ->label('Fetched At')
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Content')
                    ->limit(50)
                    ->wrap(),
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
            'index' => Pages\ListLinkContents::route('/'),
            'create' => Pages\CreateLinkContent::route('/create'),
            'edit' => Pages\EditLinkContent::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}

