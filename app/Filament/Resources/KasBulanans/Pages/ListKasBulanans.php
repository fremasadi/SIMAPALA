<?php

namespace App\Filament\Resources\KasBulanans\Pages;

use App\Filament\Resources\KasBulanans\KasBulananResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

class ListKasBulanans extends ListRecords
{
    protected static string $resource = KasBulananResource::class;

    public function mount(): void
    {
        parent::mount();
        $this->runGenerateKas();
    }

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('generate_kas')
            //     ->label('Generate Kas Bulan Ini')
            //     ->icon('heroicon-o-arrow-path')
            //     ->color('info')
            //     ->action(function () {
            //         $this->runGenerateKas();
            //         $this->resetTable();
            //     }),
        ];
    }

    private function runGenerateKas(): void
    {
        Artisan::call('kas:generate-bulanan');
    }
}
