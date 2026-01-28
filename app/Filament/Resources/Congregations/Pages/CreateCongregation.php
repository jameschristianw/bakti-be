<?php

namespace App\Filament\Resources\Congregations\Pages;

use App\Filament\Resources\Congregations\CongregationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCongregation extends CreateRecord
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
            'Tambah'
        ];
    }
}
