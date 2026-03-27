<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Products', Product::count())
                ->description('Total products in store')
                ->descriptionIcon('heroicon-m-cube')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17]),

            Stat::make('Total Orders', Order::count())
                ->description('All time orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('info')
                ->chart([15, 4, 10, 2, 12, 4, 12]),

            Stat::make('Total Revenue', 'Rp ' . number_format(Order::where('status', 'delivered')->sum('grand_total'), 0, ',', '.'))
                ->description('Total delivered orders')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning')
                ->chart([2, 10, 5, 22, 8, 15, 12]),

            Stat::make('Total Users', User::role('user')->count())
                ->description('Registered customers')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->chart([5, 10, 7, 15, 12, 8, 14]),

            Stat::make('Total Brands', Brand::count())
                ->description('Available brands')
                ->descriptionIcon('heroicon-m-tag')
                ->color('gray')
                ->chart([3, 5, 2, 8, 4, 6, 7]),

            Stat::make('Total Categories', Category::count())
                ->description('Product categories')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('danger')
                ->chart([1, 3, 2, 5, 3, 4, 6]),
        ];
    }
}
