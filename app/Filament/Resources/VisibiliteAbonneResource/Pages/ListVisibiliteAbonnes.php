<?php

namespace App\Filament\Resources\VisibiliteAbonneResource\Pages;

use App\Filament\Resources\VisibiliteAbonneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisibiliteAbonnes extends ListRecords
{
    protected static string $resource = VisibiliteAbonneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
