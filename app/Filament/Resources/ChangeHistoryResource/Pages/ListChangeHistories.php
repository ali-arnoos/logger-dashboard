<?php

namespace App\Filament\Resources\ChangeHistoryResource\Pages;

use App\Filament\Resources\ChangeHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChangeHistories extends ListRecords
{
    protected static string $resource = ChangeHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
