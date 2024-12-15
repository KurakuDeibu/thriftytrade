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
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Session;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form


        ->schema([
            Forms\Components\Section::make('User Information')
            ->columnSpan('2xs')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Username')
                            ->required(),
                        Forms\Components\TextInput::make('firstName')
                            ->label('First Name')
                            ->required(),
                        Forms\Components\TextInput::make('lastName')
                            ->label('Last Name')
                            ->required(),
                        Forms\Components\TextInput::make('middleName')
                            ->label('Middle Name')
                            ->nullable(),
                        Forms\Components\TextInput::make('userAddress')
                            ->label('Address')
                            ->required(),
                        Forms\Components\DatePicker::make('birthDay')
                            ->label('Birth Date')
                            ->required(),
                        Forms\Components\TextInput::make('phoneNum')
                            ->label('Phone Number')
                            ->required(),
                    ]),

            Forms\Components\Section::make('Profile')->columnSpan('1xs')
                ->schema([
                    Forms\Components\FileUpload::make('profile_photo_path')
                        ->label('Update Profile Photo')
                        ->image()
                        ->directory('profile-photos')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email(),

                    Toggle::make('is_verified')
                        ->label('Verify Email')
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $set('email_verified_at', now());
                            } else {
                                $set('email_verified_at', null);
                            }
                        }),

            Forms\Components\Section::make('User Permissions')->columnSpan('1xs')
                ->schema([
                    Toggle::make('isAdmin')
                        ->label('Admin Access')
                        ->helperText('Allow this user to access the admin panel')
                ])

                ]),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table


            ->columns([
                TextColumn::make('name')->label('Username'),
                TextColumn::make('firstName')->label('First Name'),
                TextColumn::make('lastName')->label('Last Name'),
                TextColumn::make('middleName')->label('Middle Name'),
                TextColumn::make('userAddress')->label('Address'),
                TextColumn::make('birthDay')
                ->label('Birth Date')
                ->date('M j, Y'),
                TextColumn::make('phoneNum')->label('Phone Number'),

                ImageColumn::make('profile_photo_path')->label('Image')->circular()->width(50)->height(50),
                TextColumn::make('name')->label('Username')->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('email_verified_at')->label('Email Verified At')->sortable()->searchable(),
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
                        Tables\Actions\ViewAction::make()->label('View'), // Changed EditAction to ViewAction
                        Tables\Actions\DeleteAction::make()->label('Delete'), // Delete User
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
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
