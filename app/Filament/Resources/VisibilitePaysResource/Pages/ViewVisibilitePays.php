<?php

namespace App\Filament\Resources\VisibilitePaysResource\Pages;

use App\Filament\Resources\VisibilitePaysResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVisibilitePays extends ViewRecord
{
    protected static string $resource = VisibilitePaysResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
