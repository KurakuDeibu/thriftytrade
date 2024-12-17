<?php

namespace App\Filament\Resources\FinderVerificationResource\Pages;

use App\Filament\Resources\FinderVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinderVerifications extends ListRecords
{
    protected static string $resource = FinderVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
