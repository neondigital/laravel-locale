<?php

namespace Neondigital\LaravelLocale;

interface ViewFinderInterface
{
    public function __construct($app);

    public function find($view, $countryCode, $languageCode);
}
