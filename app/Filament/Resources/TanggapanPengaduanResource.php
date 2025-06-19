<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TanggapanPengaduanResource\Pages;
use App\Filament\Resources\TanggapanPengaduanResource\RelationManagers;
use App\Models\TanggapanPengaduan;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TanggapanPengaduanResource extends Resource
{
    protected static ?string $model = TanggapanPengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Tanggapan Pengaduan';

    protected static ?string $pluralModelLabel = 'Daftar Tanggapan Pengaduan';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaduan';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-arrow-up-on-square-stack';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getColor(): ?string
    {
        return 'primary';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul_pengaduan')
                    ->label('Judul Pengaduan')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),

                TextInput::make('nama_pelapor')
                    ->label('Nama Pelapor')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('nohp')
                    ->label('Nomor HP Pelapor')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('alamat')
                    ->label('Alamat Pelapor')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('kategori_nama')
                    ->label('Kategori Pengaduan')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('isi_pengaduan')
                    ->label('Isi Pengaduan')
                    ->disabled()
                    ->dehydrated(false)
                    ->columnSpanFull(),

                TextInput::make('isi_tanggapan')
                    ->label('Tanggapan')
                    ->required()
                    ->maxLength(100)
                    ->columnSpanFull()
                    ->helperText('Tanggapan ini akan ditampilkan pada halaman detail pengaduan. Pastikan tanggapan sesuai dengan pengaduan yang dilaporkan.'),

                Select::make('status')
                    ->label('Status Pengaduan')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'proses' => 'Proses',
                        'selesai' => 'Selesai',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('proses')
                    ->required()
                    ->columnSpanFull()
                    ->helperText('Status ini akan diperbarui pada pengaduan terkait setelah tanggapan disimpan.'),

                Hidden::make('pengaduan_id')
                    ->default(fn() => request()->query('pengaduan_id'))
                    ->required(),

                Hidden::make('kategori_id')
                    ->default(fn() => request()->query('kategori_id'))
                    ->required(),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pengaduan.judul')
                    ->label('Judul Pengaduan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('pengaduan.user.name')
                    ->label('Nama Pelapor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pengaduan.user.no_hp')
                    ->label('Nomor HP Pelapor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('pengaduan.user.alamat')
                    ->label('Alamat Pelapor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('kategori.namaKategori')
                    ->label('Kategori Pengaduan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('pengaduan.isi_pengaduan')
                    ->label('Isi Pengaduan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('isi_tanggapan')
                    ->label('Tanggapan Pengaduan')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('pengaduan.status')
                    ->label('Status Pengaduan')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->colors([
                        'primary' => 'menunggu',
                        'warning' => 'proses',
                        'success' => 'selesai',
                        'danger' => 'ditolak',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'menunggu',
                        'heroicon-o-cog' => 'proses',
                        'heroicon-o-check-circle' => 'selesai',
                        'heroicon-o-x-circle' => 'ditolak',
                    ]),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('updated_at')
                    ->label('Tanggal Diubah')
                    ->dateTime()
                    ->sortable()
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus Tanggapan')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->successNotificationTitle('Tanggapan berhasil dihapus.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTanggapanPengaduans::route('/'),
            'create' => Pages\CreateTanggapanPengaduan::route('/create'),
            'edit' => Pages\EditTanggapanPengaduan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['pengaduan', 'pengaduan.user', 'pengaduan.kategori', 'kategori', 'user']);
    }

    // public static function canCreate(): bool
    // {
    //     return false;
    // }
}
