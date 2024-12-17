<?php

namespace App\Filament\Resources\FinderVerificationResource\Pages;

use App\Filament\Resources\FinderVerificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFinderVerification extends EditRecord
{
    protected static string $resource = FinderVerificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
