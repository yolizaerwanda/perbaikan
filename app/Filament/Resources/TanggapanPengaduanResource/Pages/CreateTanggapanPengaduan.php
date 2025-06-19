<?php

namespace App\Filament\Resources\TanggapanPengaduanResource\Pages;

use App\Filament\Resources\TanggapanPengaduanResource;
use App\Models\Pengaduan;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;


class CreateTanggapanPengaduan extends CreateRecord
{
    protected static string $resource = TanggapanPengaduanResource::class;

    public $pengaduan_id;
    public $statusPengaduan;


    public function mount(): void
    {
        parent::mount();

        $pengaduan_id = request()->query('pengaduan_id');
        $kategori_id = request()->query('kategori_id');

        // Debug untuk memastikan parameter sampai
        logger('URL Parameters received:', [
            'pengaduan_id' => $pengaduan_id,
            'kategori_id' => $kategori_id,
            'full_url' => request()->fullUrl()
        ]);

        if ($pengaduan_id) {
            $pengaduan = Pengaduan::with('user', 'kategori')->find($pengaduan_id);

            if ($pengaduan) {
                // Pre-fill form dengan data pengaduan dan parameter yang diperlukan
                $this->form->fill([
                    'judul_pengaduan' => $pengaduan->judul,
                    'nama_pelapor' => $pengaduan->user->name ?? '',
                    'nohp' => $pengaduan->user->no_hp ?? '',
                    'alamat' => $pengaduan->user->alamat ?? '',
                    'kategori_nama' => $pengaduan->kategori->namaKategori ?? '',
                    'isi_pengaduan' => $pengaduan->isi_pengaduan,
                    'pengaduan_id' => $pengaduan->id,
                    'kategori_id' => $pengaduan->kategori_id,
                    'user_id' => Auth::id(),
                    'status' => 'proses',
                ]);
            }
        }
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Backup jika hidden fields tidak bekerja
        if (empty($data['pengaduan_id'])) {
            $data['pengaduan_id'] = request()->query('pengaduan_id');
        }

        if (empty($data['kategori_id'])) {
            $data['kategori_id'] = request()->query('kategori_id');
        }

        if (empty($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }

        $this->statusPengaduan = $data['status'] ?? 'proses';
        unset($data['status']);

        return $data;
    }

    protected function afterCreate(): void
    {
        // Update status di tabel pengaduan setelah tanggapan berhasil dibuat
        if ($this->record->pengaduan_id && isset($this->statusPengaduan)) {
            Pengaduan::where('id', $this->record->pengaduan_id)
                ->update(['status' => $this->statusPengaduan]);

            logger('Status pengaduan updated:', [
                'pengaduan_id' => $this->record->pengaduan_id,
                'new_status' => $this->statusPengaduan
            ]);
        }
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Tanggapan Pengaduan Dibuat')
            ->body('Tanggapan pengaduan baru telah berhasil dibuat.');
    }


    protected function getRedirectUrl(): string
    {
        return TanggapanPengaduanResource::getUrl('index');
    }
}
