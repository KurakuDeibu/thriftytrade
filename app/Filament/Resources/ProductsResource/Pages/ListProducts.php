<?php

namespace App\Filament\Resources\ProductsResource\Pages;

use App\Filament\Resources\ProductsResource;
use App\Filament\Resources\ProductsResource\Widgets\PostedProductsChart;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostedProductsChart::class
        ];
    }
    // public function getTabs(): array
    // {

    //     return
    //     [
    //         'All' => Tab::make(),
    //         'Featured' => Tab::make()->modifyQueryUsing(function (Builder $query){
    //             $query->where('featured', true);
    //         })

    //     ];
    // }
}