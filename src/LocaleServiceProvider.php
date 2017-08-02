<?php

namespace Neondigital\LaravelLocale;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Config;
use View;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'composing:*' => [
            'Neondigital\LaravelLocale\Listeners\Composing',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract  $events)
    {
        parent::boot($events);
        if (!$this->isLumen()) {
            $this->publishes([
                $this->getConfigPath() => $this->app->make('path.config') . '/locale.php',
            ], 'config');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LocaleInterface::class, function ($app) {
            return new Locale($app);
        });

        $this->app->bind(ViewFinderInterface::class, function ($app) {
            return new ViewFinder($app);
        });
    }

    /**
     * @return string
     */
    protected function getConfigPath()
    {
        return __DIR__ . '/../config/locale.php';
    }

    /**
     * @return bool
     */
    protected function isLumen()
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}
