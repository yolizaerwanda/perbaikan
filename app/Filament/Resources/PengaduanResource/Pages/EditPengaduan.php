<?php

namespace App\Filament\Resources\PengaduanResource\Pages;

use App\Filament\Resources\PengaduanResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPengaduan extends EditRecord
{
    protected static string $resource = PengaduanResource::class;

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
            ->title('Pengaduan Diperbarui')
            ->body('Pengaduan telah diperbarui dengan sukses.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load('kategori', 'user');

        $data['nama_pelapor'] = $record->user?->name;

        $data['nohp'] = $record->user?->no_hp;

        $data['alamat'] = $record->user?->alamat;

        $data['kategori_nama'] = $record->kategori?->namaKategori;

        return $data;
    }
}
