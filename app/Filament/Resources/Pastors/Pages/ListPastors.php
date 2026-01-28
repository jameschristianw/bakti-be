<?php

namespace App\Filament\Resources\Pastors\Pages;

use App\Filament\Resources\Pastors\PastorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPastors extends ListRecords
{
    protected static string $resource = PastorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
