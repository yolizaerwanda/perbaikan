<?php

namespace App\Filament\Resources\TanggapanPengaduanResource\Pages;

use App\Filament\Resources\TanggapanPengaduanResource;
use App\Models\Pengaduan;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditTanggapanPengaduan extends EditRecord
{
    protected static string $resource = TanggapanPengaduanResource::class;

    public $statusPengaduan;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Load data pengaduan yang terkait
        $tanggapan = $this->getRecord();

        if ($tanggapan && $tanggapan->pengaduan) {
            $pengaduan = $tanggapan->pengaduan()->with('user', 'kategori')->first();

            if ($pengaduan) {
                // Fill form dengan data pengaduan dan tanggapan yang sudah ada
                $this->form->fill([
                    'judul_pengaduan' => $pengaduan->judul,
                    'nama_pelapor' => $pengaduan->user->name ?? '',
                    'nohp' => $pengaduan->user->no_hp ?? '',
                    'alamat' => $pengaduan->user->alamat ?? '',
                    'kategori_nama' => $pengaduan->kategori->namaKategori ?? '',
                    'isi_pengaduan' => $pengaduan->isi_pengaduan,
                    'isi_tanggapan' => $tanggapan->isi_tanggapan,
                    'status' => $pengaduan->status, // Status dari pengaduan
                    'pengaduan_id' => $pengaduan->id,
                    'kategori_id' => $pengaduan->kategori_id,
                    'user_id' => $tanggapan->user_id,
                ]);
            }
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return TanggapanPengaduanResource::getUrl('index');
    }

    protected function getUpdatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Tanggapan Diperbarui')
            ->body('Tanggapan telah diperbarui dengan sukses.');
    }

    // Update status pengaduan saat tanggapan diupdate
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Simpan status untuk update pengaduan
        $this->statusPengaduan = $data['status'] ?? null;

        // Hapus status dari data tanggapan
        unset($data['status']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Update status pengaduan setelah tanggapan diupdate
        if ($this->record->pengaduan_id && isset($this->statusPengaduan)) {
            Pengaduan::where('id', $this->record->pengaduan_id)
                ->update(['status' => $this->statusPengaduan]);

            logger('Status pengaduan updated on edit:', [
                'pengaduan_id' => $this->record->pengaduan_id,
                'new_status' => $this->statusPengaduan,
            ]);
        }
    }
}
