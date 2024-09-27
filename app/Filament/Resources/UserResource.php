<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Session;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('Profile')
                ->schema([
                    Forms\Components\FileUpload::make('profile_photo_path')
                        ->label('Image')
                        ->required(),
                ]),
            Forms\Components\Section::make('Details')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Username')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email(),
                ]),
            Forms\Components\Section::make('Verification')
                ->schema([
                    Forms\Components\Checkbox::make('is_verified')
                        ->label('Verify Email')
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $set('email_verified_at', now());
                            } else {
                                $set('email_verified_at', null);
                            }
                        }),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')->label('Image'),
                TextColumn::make('name')->label('Username')->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('email_verified_at')->label('Email Verified At')->sortable()->searchable(),
                // TextColumn::make('slug')->label('Category')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verify')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function (User $record) {
                        $record->markEmailAsVerified();
                        $record->save();
                        // Filament::getFlash()->success('Email verified successfully!');
                    }),
                    Tables\Actions\ActionGroup::make([
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make()->label('Block'),
                    ])->icon('heroicon-o-ellipsis-vertical'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}