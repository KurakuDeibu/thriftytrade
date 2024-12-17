<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Product Management';
    protected static ?string $navigationLabel = 'Reviews';
    protected static ?int $navigationSort = 26;


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('reviewer_id')
                ->label('Reviewer')
                ->relationship('reviewer', 'name') // Assuming you have a relationship in your Review model
                ->required(),
            Forms\Components\Select::make('reviewee_id')
                ->label('Reviewee')
                ->relationship('reviewee', 'name') // Assuming you have a relationship in your Review model
                ->required(),
            Forms\Components\Select::make('products_id')
                ->label('Product')
                ->relationship('product', 'prodName') // Assuming you have a relationship in your Review model
                ->required(),
            Forms\Components\Textarea::make('content')
                ->label('Content')
                ->nullable(),
            Forms\Components\Select::make('rating')
                ->label('Rating')
                ->options([
                    1 => '1 Star',
                    2 => '2 Stars',
                    3 => '3 Stars',
                    4 => '4 Stars',
                    5 => '5 Stars',
                ])
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('reviewer.name')->label('Reviewer'),
            Tables\Columns\TextColumn::make('reviewee.name')->label('Reviewee'),
            Tables\Columns\TextColumn::make('product.prodName')->label('Product'),
            Tables\Columns\TextColumn::make('content')->label('Content'),
            Tables\Columns\TextColumn::make('rating')->label('Rating')->badge(),
            Tables\Columns\TextColumn::make('created_at')->label('Reviewed At')->dateTime(),
        ])
        ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListReviews::route('/'),
            // 'create' => Pages\CreateReview::route('/create'),
            // 'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}