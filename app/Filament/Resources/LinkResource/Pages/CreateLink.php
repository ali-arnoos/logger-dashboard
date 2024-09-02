<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Resources\LinkResource;
use Filament\Resources\Pages\CreateRecord;
use App\Services\LinkDataExtractor;
use App\Models\LinkContent;

class CreateLink extends CreateRecord
{
    protected static string $resource = LinkResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $extractedData = LinkDataExtractor::extract($data['url']);

        $data['headers'] = json_encode($extractedData['headers']);
        $data['query_parameters'] = json_encode($extractedData['query_parameters']);
        $data['method'] = $extractedData['method'];

        return $data;
    }

    protected function afterCreate(): void
    {
        $link = $this->record;

        $extractedData = LinkDataExtractor::extract($link->url);

        LinkContent::create([
            'link_id' => $link->id,
            'content' => $extractedData['content'],
        ]);
    }
}