<?php

namespace App\Filament\Resources\VisibilitePaysResource\Pages;

use App\Filament\Resources\VisibilitePaysResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisibilitePays extends EditRecord
{
    protected static string $resource = VisibilitePaysResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
