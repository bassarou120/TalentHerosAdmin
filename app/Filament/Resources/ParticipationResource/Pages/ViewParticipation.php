<?php

namespace App\Filament\Resources\ParticipationResource\Pages;

use App\Filament\Resources\ParticipationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewParticipation extends ViewRecord
{
    protected static string $resource = ParticipationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
