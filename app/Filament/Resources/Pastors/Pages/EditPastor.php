<?php

namespace App\Filament\Resources\Pastors\Pages;

use App\Filament\Resources\Pastors\PastorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPastor extends EditRecord
{
    protected static string $resource = PastorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
