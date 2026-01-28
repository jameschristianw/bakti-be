<?php

namespace App\Filament\Resources\Congregations\Pages;

use App\Filament\Resources\Congregations\CongregationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCongregations extends ListRecords
{
    protected static string $resource = CongregationResource::class;

    public function getTitle(): string
    {
        return 'Jemaat';
    }

    public function getBreadcrumbs(): array
    {
        return [
            url()->current() => 'Jemaat',
            'Daftar'
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Jemaat'),
        ];
    }
}
