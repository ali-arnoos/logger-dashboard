<x-filament::page>

    <div class="mb-6">
        <p><strong>URL:</strong> {{ $record->url }}</p>
        <p><strong>Status:</strong> {{ $record->status }}</p>
    </div>

    <livewire:link-history :linkId="$record->id" />
</x-filament::page>
