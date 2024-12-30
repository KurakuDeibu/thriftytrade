<?php

namespace App\Filament\Exports;

use App\Models\Products;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProductExporter extends Exporter
{
    protected static ?string $model = Products::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('Product ID'),
            ExportColumn::make('author.name')->label('Listed By'),
            ExportColumn::make('prodName')->label('Listing Name'),
            ExportColumn::make('prodDescription')->label('Description'),
            ExportColumn::make('prodPrice')->label('Price'),
            ExportColumn::make('prodCondition')->label('Condition'),
            ExportColumn::make('status')->label('Status'),
            ExportColumn::make('price_type')->label('Price Type'),
            ExportColumn::make('location')->label('Location'),
            ExportColumn::make('finders_fee')->label('Finders fee'),
            ExportColumn::make('category.categName')->label('Category'),
            ExportColumn::make('featured')->label('Is Featured'),
            ExportColumn::make('is_looking_for')->label('Is Looking For'),

            ExportColumn::make('created_at')->label('Created At'),
            ExportColumn::make('updated_at')->label('Updated At'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}