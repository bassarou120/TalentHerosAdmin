<?php

namespace App\Filament\Resources\VisibilitePaysResource\Pages;

use App\Filament\Resources\VisibilitePaysResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisibilitePays extends ListRecords
{
    protected static string $resource = VisibilitePaysResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
