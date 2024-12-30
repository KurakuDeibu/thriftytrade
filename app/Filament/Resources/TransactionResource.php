<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TransactionExporter;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Products;
use App\Models\Transaction;
use App\Models\User;
use Filament\Tables\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
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
    protected static ?int $navigationSort = 40;

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
                TextColumn::make('tranStatus')->badge()
                    ->label('Transaction Status'),
                // TextColumn::make('systemCommission')
                //     ->label('System Commission'),
                // TextColumn::make('finderCommission')
                //     ->label('Finder Commission'),

            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                ->form([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->headerActions([
                ExportAction::make()->exporter(TransactionExporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()->exporter(TransactionExporter::class)
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('tranStatus', 'completed')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}