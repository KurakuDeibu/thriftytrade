<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Users', User::where('created_at', '>=', now()->subWeek())->count())
                ->icon('heroicon-o-user'),
            Stat::make('Verified Users', User::where('email_verified_at', '!=', null)->count())
                ->icon('heroicon-o-check-badge'),
            Stat::make('Total Users', User::count())
                ->icon('heroicon-o-users'),
        ];
    }
}
