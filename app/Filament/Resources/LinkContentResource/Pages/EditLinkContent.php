<?php

namespace App\Filament\Resources\LinkContentResource\Pages;

use App\Filament\Resources\LinkContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLinkContent extends EditRecord
{
    protected static string $resource = LinkContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
