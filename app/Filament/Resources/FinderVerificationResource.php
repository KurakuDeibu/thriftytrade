<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinderVerificationResource\Pages;
use App\Filament\Resources\FinderVerificationResource\RelationManagers;
use App\Models\FinderVerification;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FinderVerificationResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Pending Verification';
    protected static ?string $navigationIcon = 'heroicon-o-viewfinder-circle';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'Finder Verifications';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\FileUpload::make('finder_document_path')
                ->label('ID Document')
                ->disabled(),
            Forms\Components\Textarea::make('finder_verification_notes')
                ->label('Verification Notes'),
            Forms\Components\Select::make('finder_status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected'
                ])
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            Tables\Columns\TextColumn::make('finder_status')->badge()
                ->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected'
                ])
        ])
        ->defaultGroup('finder_status')
        ->defaultSort('updated_at', 'asc')
        ->filters([
            Tables\Filters\Filter::make('Verified Finder')
            ->label('Verified Finder')
            ->query(fn (Builder $query) => $query->where('isFinder', true)),

                Tables\Filters\SelectFilter::make('pending')
                ->label('Pending')
                ->query(fn (Builder $query) => $query->where('finder_status', 'pending')),

            Tables\Filters\Filter::make('approved')
                ->label('Approved')
                ->query(fn (Builder $query) => $query->where('finder_status', 'approved')),

            Tables\Filters\Filter::make('rejected')
                ->label('Rejected')
                ->query(fn (Builder $query) => $query->where('finder_status', 'rejected')),
    ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label('View'),

            Tables\Actions\Action::make('approve')
                ->action(function (User $record) {
                    $record->update([
                        'finder_status' => 'approved',
                        'isFinder' => true,
                        'finder_verified_at' => now()
                    ]);

                    Notification::make()
                    ->title('Finder Verification Approved.')
                    ->success()
                    ->send();

                })
                ->visible(fn (User $record) => $record->finder_status === 'pending'),

            Tables\Actions\Action::make('reject')
                ->action(function (User $record) {
                    $record->update([
                        'finder_status' => 'rejected',
                        'isFinder' => false
                    ]);
                    Notification::make()
                    ->title('Finder Verification Rejected.')
                    ->danger()
                    ->send();
                })
                ->visible(fn (User $record) => $record->finder_status === 'pending')
            ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFinderVerifications::route('/'),
            // 'create' => Pages\CreateFinderVerification::route('/create'),
            // 'edit' => Pages\EditFinderVerification::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('finder_status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

}