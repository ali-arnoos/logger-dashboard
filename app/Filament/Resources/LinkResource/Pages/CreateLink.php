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

        $data['headers'] = json_encode($extractedData['headers']);
        $data['query_parameters'] = json_encode($extractedData['query_parameters']);
        $data['method'] = $extractedData['method'];
        $data['content'] = $extractedData['content'];

        return $data;
    }

}