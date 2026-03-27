<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = '📈 Orders Overview (Last 7 Days)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $data = $this->getOrdersPerDay();

        return [
            'datasets' => [
                [
                    'label' => 'Orders per day',
                    'data' => $data['ordersPerDay'],
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Revenue per day (in thousands)',
                    'data' => $data['revenuePerDay'],
                    'borderColor' => '#F59E0B',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getOrdersPerDay(): array
    {
        $now = Carbon::now();
        $ordersPerDay = [];
        $revenuePerDay = [];
        $labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);
            $labels[] = $date->format('M j');

            $ordersCount = Order::whereDate('created_at', $date)->count();
            $revenue = Order::whereDate('created_at', $date)
                          ->where('status', 'delivered')
                          ->sum('grand_total') / 1000; // Convert to thousands

            $ordersPerDay[] = $ordersCount;
            $revenuePerDay[] = round($revenue, 1);
        }

        return [
            'ordersPerDay' => $ordersPerDay,
            'revenuePerDay' => $revenuePerDay,
            'labels' => $labels,
        ];
    }
}
