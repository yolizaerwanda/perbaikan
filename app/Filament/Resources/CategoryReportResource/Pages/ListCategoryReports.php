<?php

namespace App\Filament\Resources\CategoryReportResource\Pages;

use App\Filament\Resources\CategoryReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryReports extends ListRecords
{
    protected static string $resource = CategoryReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
