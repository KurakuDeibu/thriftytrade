<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Reporting Management';
    protected static ?string $navigationLabel = 'Reports';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Report Details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('report_type')
                            ->label('Report Type')
                            ->options([
                                'product' => 'Product Listing',
                                'user' => 'User Profile'
                            ])
                            ->required(),

                        Forms\Components\Select::make('products_id')
                            ->label('Reported Product')
                            ->relationship('product', 'prodName')
                            ->visible(fn ($get) => $get('report_type') === 'product'),

                        Forms\Components\Select::make('reported_user_id')
                            ->label('Reported User')
                            ->relationship('reportedUser', 'name')
                            ->visible(fn ($get) => $get('report_type') === 'user'),

                        Forms\Components\Select::make('user_id')
                            ->label('Reporter')
                            ->relationship('reporter', 'name')
                            ->required(),

                        Forms\Components\Select::make('reason')
                            ->label('Reason')
                            ->options([
                                'inappropriate' => 'Inappropriate Content',
                                'fraud' => 'Fraudulent Listing',
                                'harassment' => 'Harassment',
                                'spam' => 'Spam or Scam',
                                'misleading' => 'Misleading Information',
                                'impersonation' => 'Impersonation',
                                'offensive' => 'Offensive Content',
                                'privacy' => 'Privacy Violation',
                                'malicious' => 'Malicious Activity',
                                'fake_profile' => 'Fake Profile',
                                'duplicate' => 'Duplicate Listing',
                                'prohibited' => 'Prohibited Content',
                                'condition' => 'Condition Misrepresentation',
                                'copyright' => 'Copyright Infringement',
                                'safety' => 'Safety Concern',
                                'other' => 'Other'
                            ])
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'reviewed' => 'Reviewed',
                                'resolved' => 'Resolved',
                                'dismissed' => 'Dismissed'
                            ])
                            ->default('pending')
                            ->required(),
                    ]),

                Forms\Components\Textarea::make('details')
                    ->label('Report Details')
                    ->rows(4)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->sortable(),

            Tables\Columns\TextColumn::make('reporter.name')
                ->label('Reporter')
                ->searchable(),

                // Reported Resource Image Column
                Tables\Columns\ImageColumn::make('reported_resource_image')
                    ->label('Image')
                    ->circular()
                    ->size(50)
                    ->getStateUsing(function (Report $record) {
                        if ($record->report_type === 'product' && $record->product) {
                            // Use the product image from the marketplace products
                            return $record->product->prodImage
                                   ? asset('storage/' . $record->product->prodImage)
                                   : asset('img/NOIMG.jpg');
                        } elseif ($record->report_type === 'user' && $record->reportedUser) {
                            // Use the user's profile photo URL
                            return $record->reportedUser->profile_photo_url;
                        }
                        return null;
                    }),

            Tables\Columns\TextColumn::make('report_type')
                ->label('Report Type')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'product' => 'primary',
                    'user' => 'warning',
                    default => 'gray',
                }),


            Tables\Columns\TextColumn::make('reason')
                ->label('Reason')
                ->searchable(),

            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'reviewed' => 'info',
                    'resolved' => 'success',
                    'dismissed' => 'danger',
                    default => 'gray',
                }),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Reported On')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('report_type')
                ->options([
                    'product' => 'Product Listing',
                    'user' => 'User Profile'
                ]),

            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'reviewed' => 'Reviewed',
                    'resolved' => 'Resolved',
                    'dismissed' => 'Dismissed'
                ]),
        ])
        ->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make()->label('View'),

            // Custom Status Change Actions
            Tables\Actions\Action::make('mark_reviewed')
                ->label('Mark Reviewed')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->action(function (Report $record) {
                    $record->update(['status' => 'reviewed']);

                    Notification::make()
                        ->title('Report Marked as Reviewed')
                        ->success()
                        ->send();
                })
                ->visible(fn (Report $record) => $record->status === 'pending'),

                Tables\Actions\Action::make('mark_resolved')
                ->label('Mark Resolved')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function (Report $record) {
                    $record->update(['status' => 'resolved']);

                    Notification::make()
                        ->title('Report Marked as Resolved')
                        ->success()
                        ->send();
                })
                ->visible(fn (Report $record) => in_array($record->status, ['pending', 'reviewed'])),

                Tables\Actions\Action::make('mark_dismissed')
                ->label('Dismiss Report')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->action(function (Report $record) {
                    $record->update(['status' => 'dismissed']);

                    Notification::make()
                        ->title('Report Dismissed')
                        ->danger()
                        ->send();
                })
                ->visible(fn (Report $record) => in_array($record->status, ['pending', 'reviewed'])),
        ])
    ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            // 'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}