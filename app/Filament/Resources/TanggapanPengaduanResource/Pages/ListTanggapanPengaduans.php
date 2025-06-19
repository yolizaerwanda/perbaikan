<?php

namespace App\Filament\Resources\TanggapanPengaduanResource\Pages;

use App\Filament\Resources\TanggapanPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTanggapanPengaduans extends ListRecords
{
    protected static string $resource = TanggapanPengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
