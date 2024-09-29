<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $newUsersCount = User::where('created_at', '>=', now()->subWeek())->count();
        $verifiedUsersCount = User::where('email_verified_at', '!=', null)->count();
        $totalUsersCount = User::count();

        return [
            Stat::make('New Users', $newUsersCount)
                ->description('New users that have joined')
                ->descriptionIcon('heroicon-o-user', IconPosition::Before)
                ->chart([0,$newUsersCount])
                ->color('info'),
            Stat::make('Verified Users', $verifiedUsersCount)
                ->description('Users that are verified')
                ->descriptionIcon('heroicon-o-check-badge', IconPosition::Before)
                ->chart([0, $verifiedUsersCount])
                ->color('primary'),
            Stat::make('Total Users', $totalUsersCount)
                ->description('All registered users')
                ->descriptionIcon('heroicon-o-users', IconPosition::Before)
                ->chart([0, $totalUsersCount])
                ->color('primary'),
        ];
    }
}