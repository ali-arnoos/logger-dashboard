<?php
 
namespace App\Livewire;

use App\Models\ChangeHistory;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Filament\Tables\Actions\Action;

class LinkHistory extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    
    public $linkId;

    public function mount($linkId)
    {
        $this->linkId = $linkId;
    }

    public function table(Table $table): Table
    {
        return $table
        ->query(ChangeHistory::query()->where('link_id', $this->linkId)) // Filter by link_id
        ->columns([
            TextColumn::make('link.url')
                ->label('Link URL')
                ->searchable()
                ->sortable()->limit(50),
            TextColumn::make('created_at')
                ->label('Created At')
                ->sortable(),
            IconColumn::make('is_changed')
                ->label('Changed')
                ->boolean() 
                ->sortable()
                ->trueIcon('heroicon-o-check-circle') 
                ->falseIcon('heroicon-o-x-circle')
                ->alignment('center'),
            TextColumn::make('old_content')
                ->label('Old Content')
                ->limit(50)
                ->wrap(),
            TextColumn::make('new_content')
                ->label('New Content')
                ->limit(50)
                ->wrap(),
            TextColumn::make('name')
                ->label('User Name'),
            TextColumn::make('user_id')
                ->label('User ID'),
        ])
        ->filters([
            // You can define filters here
        ])
        ->actions([
            Action::make('view')
                ->label('View')
                ->icon('heroicon-o-eye')
                ->url(fn (ChangeHistory $record) => url("/admin/change-histories/{$record->id}"))
        ])
        ->bulkActions([
        ]);
    }
    
    public function render(): View
    {
        return view('livewire.link-history');
    }
}