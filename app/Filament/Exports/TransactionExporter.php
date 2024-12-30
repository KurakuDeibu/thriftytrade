<?php

namespace App\Filament\Exports;

use App\Models\Transaction;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
// use OpenSpout\Common\Entity\Style\CellAlignment;
// use OpenSpout\Common\Entity\Style\CellVerticalAlignment;
// use OpenSpout\Common\Entity\Style\Color;
// use OpenSpout\Common\Entity\Style\Style;


class TransactionExporter extends Exporter
{
    protected static ?string $model = Transaction::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('Transaction ID'),
            ExportColumn::make('product.author.name')->label('Listed By'),
            ExportColumn::make('buyer.name')->label('Buyer Name'),
            ExportColumn::make('product.prodName')->label('Listing Name'),
            ExportColumn::make('offer.offer_price')->label('Offered Price'),
            ExportColumn::make('tranStatus')->label('Status'),
            ExportColumn::make('meetup_location')->label('Meetup Location'),
            ExportColumn::make('meetup_time')->label('Meetup Time'),

            // DATE TIMESTAMP
            ExportColumn::make('tranDate')->label('Transaction Completed At'),

        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your transaction export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }

    // ----- STYLE FOR EXCEL IF NEEDED -------//
    // public function getXlsxHeaderCellStyle(): ?Style
    // {
    //     return (new Style())
    //         ->setFontBold()
    //         ->setFontItalic()
    //         ->setFontSize(14)
    //         ->setFontName('Consolas')
    //         ->setFontColor(Color::rgb(255, 255, 77))
    //         ->setBackgroundColor(Color::rgb(0, 0, 0))
    //         ->setCellAlignment(CellAlignment::CENTER)
    //         ->setCellVerticalAlignment(CellVerticalAlignment::CENTER);
    // }

}