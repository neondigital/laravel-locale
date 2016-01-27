<?php

namespace Neondigital\LaravelLocale;

interface LocaleInterface
{
    public function getAll();

    public function getAllByGroup($group);

    public function getRedirects();

    public function getLocale();

    public function getCountryCode();

    public function getLanguageCode();

    public function getUrlPrefix();

    public function url($path = null, $parameters = [], $secure = null);

    public function secureUrl($path, $parameters = []);

    public function htmlTags();

    public function getAlternateUrl($locale);
}
