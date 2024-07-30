<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('prodName')
                    ->live()
                    ->minLength(1)
                    ->label('Product Name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                Select::make('prodCategory')
                    ->label('Product Category')
                    ->multiple()
                    ->relationship('categories', 'title')
                    ->searchable(),
                // ->required(),
                TextInput::make('prodPrice')
                    ->label('Product Price')
                    ->numeric()
                    ->required(),
                Select::make('prodCondition')
                    ->label('Product Condition')
                    ->options([
                        // add your condition options here
                        'new' => 'New',
                        'used' => 'Used',
                        // ...
                    ]),
                // ->required(),
                TextInput::make('prodCommissionFee')
                    ->label('Product Commission Fee')
                    ->numeric()
                    ->required(),
                FileUpload::make('prodImage')
                    ->label('Product Image')
                    ->required()
                    // ->fileAttachmentsDirectory('products/images')
                    ->columnSpanFull(),
                RichEditor::make('prodDescription')
                    ->label('Product Description')
                    ->columnSpanFull()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('prodImage')->label('Image'),
                TextColumn::make('prodName')->label('Product Name')->sortable()->searchable(),
                // TextColumn::make('slug')->label('Category')->sortable()->searchable(),
                TextColumn::make('prodPrice')->label('Price')->sortable()->searchable(),
                TextColumn::make('prodCondition')->label('Condition')->sortable()->searchable(),
                TextColumn::make('prodCommissionFee')->label('Commission Fee')->sortable()->searchable(),
                CheckboxColumn::make('featured'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}
