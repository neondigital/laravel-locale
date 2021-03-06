<?php

namespace Neondigital\LaravelLocale;

interface LocaleInterface
{
    public function getAll();

    public function getAllByGroup($group);

    public function getRedirects();

    public function current();

    public function setCurrent($prefix);

    public function getUrlPrefix();

    public function url($path = null, $parameters = [], $secure = null);

    public function secureUrl($path, $parameters = []);

    public function htmlTags();

    public function getAlternateUrl($locale);
}
