<?php

namespace Neondigital\LaravelLocale;

use Neondigital\LaravelLocale\Models\Locale as LocaleModel;
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
        return $this->getAllByGroup();
    }

    public function getAllByGroup($group = null)
    {
        $locales = [];

        foreach (Config::get('locale.locales', []) as $prefix => $locale) {
            if (!$group or $locale['group'] == $group) {
                $locales[] = new LocaleModel($prefix, $locale);
            }
        }

        return $locales;
    }

    public function getRedirects()
    {
        return Config::get('locale.redirects', []);
    }

    public function getLocale($countryCode = 'GB')
    {
        $locales = Config::get('locale.locales', []);
        foreach ($locales as $prefix => $locale) {
            if ($locale['country_code'] == $countryCode) {
                return new LocaleModel($prefix, $locale);
            }
        }
    }

    public function current()
    {
        $locales = Config::get('locale.locales', []);

        if (!isset($this->locale)) {
            $this->locale = new LocaleModel(Config::get('locale.default'), $locales[Config::get('locale.default')]);
        }

        return $this->locale;
    }

    public function setCurrent($prefix) {
        $locales = Config::get('locale.locales', []);
        $this->locale = new LocaleModel($prefix, $locales[$prefix]);
    }

    public function getUrlPrefix()
    {
        // Determine prefix from request
        $prefix = Request::segment(1);

        $locales = Config::get('locale.locales', []);

        if (isset($locales[$prefix])) {
            $this->locale = new LocaleModel($prefix, $locales[$prefix]);

            // Set default language
            App::setLocale($this->locale->getLanguageCode());

            return $this->locale->getPrefix();
        }

        return Config::get('locale.default');
    }

    public function url($path = null, $parameters = [], $secure = null)
    {
        return url($this->current()->getPrefix() . '/' . $path, $parameters, $secure);
    }

    public function secureUrl($path, $parameters = [])
    {
        return $this->url($path, $parameters, true);
    }

    public function htmlTags()
    {
        $html = '';

        // Tags for this page
        $html .= '<meta http-equiv="content-language" content="'.$this->current()->getLocaleCode().'">' . PHP_EOL;

        // Meta tags for alternate pages
        foreach ($this->getAll() as $locale) {
            if ($locale != $this->locale) {
                $html .= '<link rel="alternative" hreflang="'.$locale->getLocaleCode().'" href="'.$this->getAlternateUrl($locale).'">' . PHP_EOL;
            }
        }

        return $html;
    }

    public function getAlternateUrl($locale)
    {
        if (is_string($locale)) {
            $localeCode = $locale;
        } else {
            $localeCode = $locale->getLocaleCode();
        }

        $segments = Request::segments();

        $url = Request::root() . '/' . $localeCode;

        // If there is only one segment and its not the same as
        if (count($segments) == 1) {
            $url .= '/' . $segments[0];
        } else {
            array_shift($segments);
            if (count($segments)) {
                $url .= '/' . implode('/', $segments);
            }
        }

        if (Request::getQueryString()) {
            $url .= '?' . Request::getQueryString();
        }

        return $url;
    }
}
