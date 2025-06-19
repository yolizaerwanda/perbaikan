<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryReportResource\Pages;
use App\Models\CategoryReport;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Table;

class CategoryReportResource extends Resource
{
    protected static ?string $model = CategoryReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kategori Laporan';

    protected static ?string $pluralModelLabel = 'Kategori Laporan';

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaduan';
    }

    public static function getNavigationIcon(): string
    {
        return 'heroicon-o-rectangle-stack';
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
                Forms\Components\TextInput::make('namaKategori')
                    ->label('Nama Kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required(),
                Forms\Components\DatePicker::make('created_at')
                    ->label('Created At')
                    ->required()
                    ->native(false)
                    ->default(now()),
                Forms\Components\DatePicker::make('updated_at')
                    ->label('Updated At')
                    ->required()
                    ->native(false)
                    ->default(now()),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('namaKategori')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('deskripsi')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->label('Hapus Kategori')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->successNotificationTitle('Kategori berhasil dihapus.'),
                ])->label('Aksi'),
            ])
            ->bulkActions([
                BulkAction::make('editKategori')
                    ->label('Edit')
                    ->form([
                        TextInput::make('namaKategori')
                            ->label('Nama Kategori')
                            ->required(),
                        TextInput::make('deskripsi')
                            ->label('Deskripsi')
                            ->required(),
                    ])
                    ->action(function (array $data, $records) {
                        foreach ($records as $record) {
                            $record->update([
                                'namaKategori' => $data['namaKategori'],
                                'deskripsi' => $data['deskripsi'],
                            ]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->color('warning')
                    ->icon('heroicon-o-pencil'),

                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn ($records) => $records->each->delete())
                    ->icon('heroicon-o-trash'),
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
            'index' => Pages\ListCategoryReports::route('/'),
            'create' => Pages\CreateCategoryReport::route('/create'),
            'edit' => Pages\EditCategoryReport::route('/{record}/edit'),
        ];
    }
}
