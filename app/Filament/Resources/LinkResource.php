<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Filament\Resources\LinkResource\Pages\ViewLinkHistory;
use App\Models\Link;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('url')
                ->required()
                ->url()
                ->unique(Link::class, 'url', ignoreRecord: true)
                ->label('URL')
                ->disabled(fn ($record) => $record !== null),
            Select::make('status')
                ->options([
                    'active' => 'Active',
                    'disabled' => 'Disabled',
                ])
                ->default('active')
                ->label('Status'),
            Repeater::make('headers')
                ->label('Headers')
                ->schema([
                    TextInput::make('key')->label('Key')->required(),
                    TextInput::make('value')->label('Value')->required(),
                ])
                ->columns(2)
                ->collapsible()
                ->default([]),
            Repeater::make('query_parameters')
                ->label('Query Parameters')
                ->schema([
                    TextInput::make('key')->label('Key')->required(),
                    TextInput::make('value')->label('Value')->required(),
                ])
                ->columns(2)
                ->collapsible()
                ->default([])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable()->limit(50),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Content')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // You can define filters here
            ])
            ->actions([
                Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn (Link $record) => $record->refreshLink()),
                Tables\Actions\EditAction::make(),
                Action::make('viewHistory')
                    ->label('View History')
                    ->url(fn (Link $record) => Pages\LinkHistory::getUrl(['record' => $record->id])) 
                    ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
            'history' => Pages\LinkHistory::route('/{record}/history'), 
        ];
    }
}
