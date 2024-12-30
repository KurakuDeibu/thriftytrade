<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ProductExporter;
use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use Filament\Tables\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Tables\Columns\IconColumn;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Product Details')
                    ->schema([
                        TextInput::make('prodName')
                            ->live()
                            ->minLength(1)
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('prodPrice')
                            ->label('Product Price')
                            ->numeric()
                            ->required(),
                        Select::make('prodCondition')
                            ->label('Product Condition')
                            ->options([
                                'likely-used' => 'Likely Used',
                                'used' => 'Used',
                                'new' => 'New',
                            ]),
                        // TextInput::make('prodCommissionFee')
                        //     ->label('Product Commission Fee')
                        //     ->numeric()
                        //     ->required(),

                            Select::make('user_id')->label('Posted By')->options(User::pluck('name', 'id'))->required(),
                            Select::make('category_id')->label('Category')->options(Category::pluck('categName', 'id')),

                        RichEditor::make('prodDescription')
                            ->label('Product Description')
                            ->required(),
                    ])->columnSpan(1),

                Section::make('Product Image & Featured')
                    ->schema([
                        Group::make()->schema([
                            FileUpload::make('prodImage')
                                ->image()
                                ->directory('products/images')
                                ->label('Product Image')
                                ->required(),
                                Toggle::make('featured')
                                ->label('Featured'),
                        ]),
                    ])->columnSpan(1),

        ]);
}

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                // CheckboxColumn::make('featured')->label('Is Featured')->sortable(),

                TextColumn::make('author.name')->label('Listed By')->sortable()->searchable(),

                ImageColumn::make('prodImage')->label('Image'),
                TextColumn::make('prodName')->label('Product Name')->sortable()->searchable(),

                TextColumn::make('category.categName')->label('Category')->searchable()->sortable(),
                TextColumn::make('prodCondition')->label('Condition')->sortable()->searchable(),

                TextColumn::make('prodPrice')->label('Price')->sortable(),
                // TextColumn::make('prodCommissionFee')->label('Commission Fee')->sortable(),

                IconColumn::make('featured')->boolean()->label('Is Featured'),
                IconColumn::make('is_looking_for')->boolean()->label('Is Looking For'),
            ])
            ->defaultSort('created_at', 'desc')

            ->filters([
                Tables\Filters\Filter::make('Non-Featured')
                ->query(fn (Builder $query) => $query->where('featured', false)),

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

                Tables\Actions\Action::make('toggle-feature')
                        ->label(fn (Products $record) => $record->featured ? 'Unfeature' : 'Feature')
                        ->icon(fn (Products $record) => $record->featured ? 'heroicon-o-star' : 'heroicon-o-star')
                        ->action(function (Products $record) {
                            $record->featured = !$record->featured;
                            $record->save();
                        }),

                Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make()->label('View'), // <--- Added ViewAction to view product info

                    Tables\Actions\EditAction::make(), // Disabled edit

                        Tables\Actions\DeleteAction::make(),
                    ]),
            ])

            ->headerActions([
                ExportAction::make()->exporter(ProductExporter::class)
            ])


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()->exporter(ProductExporter::class)

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
            // 'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}