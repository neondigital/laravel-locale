<?php

namespace Neondigital\LaravelLocale\Listeners;

use Neondigital\LaravelLocale\ViewFinderInterface;
use Neondigital\LaravelLocale\LocaleInterface;

class Composing
{
    protected $locale;
    protected $viewFinder;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LocaleInterface $locale, ViewFinderInterface $viewFinder)
    {
        $this->locale = $locale;
        $this->viewFinder = $viewFinder;
    }

    /**
     * Handle the event.
     *
     * @param  Composing.*  $event
     * @return void
     */
    public function handle($view)
    {
        $this->viewFinder->find($view, $this->locale->getCountryCode(), $this->locale->getLanguageCode());
    }
}
