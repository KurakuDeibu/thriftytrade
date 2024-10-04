<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Products;
use App\Models\Transaction;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $label = 'Transactions';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Transaction Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('User:')
                            ->required()
                            ->options(User::pluck('name', 'id')),
                        Select::make('products_id')
                            ->label('Item Product:')
                            ->required()
                            ->options(Products::pluck('prodName', 'id')),
                    ]),
                Grid::make(2)
                    ->schema([
                        DateTimePicker::make('tranDate')
                            ->label('Transaction Date')
                            ->required(),
                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->required()
                            ->numeric(),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('totalPrice')
                            ->label('Total Price')
                            ->required(),
                        TextInput::make('tranStatus')
                            ->label('Transaction Status')
                            ->required(),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('systemCommission')
                            ->label('System Commission')
                            ->required(),
                        TextInput::make('finderCommission')
                            ->label('Finder Commission')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('User  ID'),
                TextColumn::make('products_id')
                    ->label('Product ID'),
                TextColumn::make('tranDate')
                    ->label('Transaction Date'),
                TextColumn::make('quantity')
                    ->label('Quantity'),
                TextColumn::make('totalPrice')
                    ->label('Total Price'),
                TextColumn::make('tranStatus')
                    ->label('Transaction Status'),
                TextColumn::make('systemCommission')
                    ->label('System Commission'),
                TextColumn::make('finderCommission')
                    ->label('Finder Commission'),

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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
