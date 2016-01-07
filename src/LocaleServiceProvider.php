<?php

namespace Neondigital\LaravelLocale;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Config;
use View;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        if (!$this->isLumen()) {
            $this->publishes([
                $this->getConfigPath() => config_path('locale.php'),
            ], 'config');
        }

        $events->listen('composing:*', function ($view) {

            $locale = $this->app['locale'];

            $viewFinder = new ViewFinder($view);
            $viewFinder->find($locale->getCountryCode(), $locale->getLanguageCode());
            
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['locale'] = $this->app->share(function ($app) {
            return new Locale();
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
