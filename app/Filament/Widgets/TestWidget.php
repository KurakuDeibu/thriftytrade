<?php

namespace App\Filament\Widgets;

use App\Models\Products;
use App\Models\Report;
use App\Models\Review;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TestWidget extends BaseWidget
{
    protected function getStats(): array
    {
        // $newUsersCount = User::where('created_at', '>=', now()->subWeek())->count();
        $verifiedUsersCount = User::where('email_verified_at', '!=', null)->count();
        $totalUsersCount = User::count();
        $totalFinderCount = User::where('isFinder', true)->count();

        // Product Statistics
        $totalProducts = Products::count();
        $soldProducts = Products::where('status', 'sold')->count();
        $availableProducts = Products::where('status', 'available')->count();
        $pendingProducts = Products::where('status', 'pending')->count();
        $totalReports = Report::count();
        $totalReviews = Review::count();



        return [
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

                Stat::make('Total Finders', $totalFinderCount)
                ->description('All verified finder')
                ->descriptionIcon('heroicon-o-viewfinder-circle', IconPosition::Before)
                ->chart([0, $totalFinderCount])
                ->color('primary'),

                Stat::make('Total Reports', $totalReports)
                ->description('All system reports', IconPosition::Before)
                ->descriptionIcon('heroicon-o-flag')
                ->chart([0, $totalReports])
                ->color('danger'),


                Stat::make('Total Products', $totalProducts)
                ->description('All listed products')
                ->descriptionIcon('heroicon-o-shopping-bag')
                ->chart([0, $totalProducts])
                ->color('primary'),

            Stat::make('Active Products', $availableProducts)
                ->description('Currently active listings')
                ->descriptionIcon('heroicon-o-check-circle')
                ->chart([0, $availableProducts])
                ->color('success'),

            Stat::make('Sold Products', $soldProducts)
                ->description('Products that have been sold')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart([0, $soldProducts])
                ->color('gray'),

                Stat::make('In Transaction', $pendingProducts)
                ->description('Products that are in transaction')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->chart([0, $pendingProducts])
                ->color('warning'),

                Stat::make('Total Reviews', $totalReviews)
                ->description('All product reviews')
                ->descriptionIcon('heroicon-o-star')
                ->chart([0, $totalReviews])
                ->color('warning'),
        ];
    }
}