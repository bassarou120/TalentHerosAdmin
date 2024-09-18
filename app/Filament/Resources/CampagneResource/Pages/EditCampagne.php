<?php

namespace App\Filament\Resources\CampagneResource\Pages;

use App\Filament\Resources\CampagneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCampagne extends EditRecord
{
    protected static string $resource = CampagneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
