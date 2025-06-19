<?php

namespace App\Filament\Resources\CategoryReportResource\Pages;

use App\Filament\Resources\CategoryReportResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCategoryReport extends CreateRecord
{
    protected static string $resource = CategoryReportResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('New Category Created')
            ->body('The new category has been created successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
