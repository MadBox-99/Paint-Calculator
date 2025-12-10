<?php

declare(strict_types=1);

namespace App\Filament\Exports;

use App\Models\PartnerShop;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PartnerShopExporter extends Exporter
{
    protected static ?string $model = PartnerShop::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('region.name')
                ->label('Region'),
            ExportColumn::make('company_name'),
            ExportColumn::make('name'),
            ExportColumn::make('address'),
            ExportColumn::make('phone'),
            ExportColumn::make('email'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your partner shop export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
