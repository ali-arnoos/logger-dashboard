<?php

namespace App\Filament\Resources\ChangeHistoryResource\Pages;

use App\Filament\Resources\ChangeHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChangeHistory extends EditRecord
{
    protected static string $resource = ChangeHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
