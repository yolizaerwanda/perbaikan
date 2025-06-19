<?php

namespace App\Filament\Resources\CategoryReportResource\Pages;

use App\Filament\Resources\CategoryReportResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCategoryReport extends EditRecord
{
    protected static string $resource = CategoryReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getUpdatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Category Updated')
            ->body('The category has been updated successfully.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
