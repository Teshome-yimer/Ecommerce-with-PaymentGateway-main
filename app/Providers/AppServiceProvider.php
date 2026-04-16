<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Ensure storage directories exist
        $directories = [
            storage_path('app/public/livewire-tmp'),
            storage_path('app/public/products'),
            storage_path('framework/sessions'),
            storage_path('framework/cache/data'),
            storage_path('framework/views'),
        ];

        foreach ($directories as $dir) {
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
            }
        }
    }
}
