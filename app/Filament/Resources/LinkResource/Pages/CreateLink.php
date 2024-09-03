<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\LinkDataExtractor;
use App\Models\Link;
use Illuminate\Validation\ValidationException;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $extractedData = LinkDataExtractor::extract($data['url']);

        $data['headers'] = $extractedData['headers'];
        $data['query_parameters'] = $extractedData['query_parameters'];
        $data['content'] = $extractedData['content'];

        return $data;
    }

}