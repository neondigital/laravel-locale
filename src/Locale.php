<?php

namespace Neondigital\LaravelLocale;

use App;
use Config;
use Request;

class Locale implements LocaleInterface
{
    protected $app;
    protected $locale;

    /**
     * Construct
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    public function getAll()
    {
        return Config::get('locale.locales', []);
    }

    public function getAllByGroup()
    {
        return [];
    }

    public function getRedirects()
    {
        return Config::get('locale.redirects', []);
    }

    public function getLocale()
    {
        $locales = $this->getAll();

        if (!isset($locales[$this->locale])) {
            $this->locale = Config::get('locale.default');
        }

        return isset($locales[$this->locale]) ? $locales[$this->locale] : [];
    }

    public function getCountryCode()
    {
        return isset($this->getLocale()['country_code']) ? $this->getLocale()['country_code'] : $this->locale;
    }

    public function getLanguageCode()
    {
        return $this->getLocale()['language_code'];
    }

    public function getUrlPrefix()
    {
        // Determine prefix from request
        $locale = Request::segment(1);

        $locales = $this->getAll();

        if (isset($locales[$locale])) {
            $this->locale = $locale;

            // Set default language
            App::setLocale($this->getLanguageCode());

            return $this->locale;
        }

        return false;
    }

    public function url($path = null, $parameters = [], $secure = null)
    {
        return url($this->getUrlPrefix() . '/' . $path, $parameters, $secure);
    }

    public function secureUrl($path, $parameters = [])
    {
        return $this->url($path, $parameters, true);
    }

    public function htmlTags()
    {
        $html = '';

        // Tags for this page
        $html .= '<meta http-equiv="content-language" content="'.$this->getLanguageCode().'">' . PHP_EOL;

        // Meta tags for alternate pages
        foreach ($this->getAll() as $locale => $info) {
            if ($locale != $this->locale) {
                $html .= '<link rel="alternative" hreflang="'.$info['language_code'].'" href="'.$this->getAlternateUrl($locale).'">' . PHP_EOL;
            }
        }

        return $html;
    }

    public function getAlternateUrl($locale)
    {
        $segments = Request::segments();
        array_shift($segments);
        $url = Request::root() . '/' . $locale;

        if (count($segments)) {
            $url .= '/' . implode('/', $segments);
        }

        if (Request::getQueryString()) {
            $url .= '?' . Request::getQueryString();
        }

        return $url;        
    }
}
