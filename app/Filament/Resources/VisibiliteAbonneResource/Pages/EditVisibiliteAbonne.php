<?php

namespace App\Filament\Resources\VisibiliteAbonneResource\Pages;

use App\Filament\Resources\VisibiliteAbonneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisibiliteAbonne extends EditRecord
{
    protected static string $resource = VisibiliteAbonneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
