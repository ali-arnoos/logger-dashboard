<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LinkResource\Pages;
use App\Models\Link;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('url')
                ->required()
                ->url()
                ->unique(Link::class, 'url', ignoreRecord: true)
                ->label('URL'),
            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'disabled' => 'Disabled',
                ])
                ->default('active')
                ->label('Status'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable(),
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
                ->action(fn (Link $record) => $record->refreshLink()),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('url')
                    ->label('URL')
                    ->columnSpanFull(),
                TextEntry::make('updated_at')
                    ->label('Changed At')
                    ->dateTime()
                    ->columnSpanFull(),
                TextEntry::make('headers')
                    ->label('Headers')
                    ->columnSpanFull(),
                TextEntry::make('query_parameters')
                    ->label('Query Parameters')
                    ->columnSpanFull(),
                TextEntry::make('status')
                    ->label('status')
                    ->columnSpanFull(),
                TextEntry::make('content')
                    ->label('Content')
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
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
            'view' => Pages\ViewLink::route('/{record}'),
        ];
    }
}
