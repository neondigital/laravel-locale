<?php

namespace Neondigital\LaravelLocale\Middleware;

use Closure;
use Config;
use NeonLocale;
use Request;


class LocaleDetection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Get country code from IP address
        $reader = new \GeoIp2\Database\Reader(storage_path('geoip2/GeoLite2-Country.mmdb'));

        try {
            $record = $reader->country(Request::ip());
            $countryCode = strtolower($record->country->isoCode);
        } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
            $countryCode = Config::get('locale.default');
        }

        // Get language from browser
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $languageCode = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        } else {
            $languageCode = null;
        }

        // Do we have this country set-up?
        $locales = Config::get('locale.locales', []);
        $redirects = NeonLocale::getRedirects();

        if (isset($locales[$countryCode]) or isset($locales[$countryCode . '-' . $languageCode]) or isset($redirects[$countryCode])) {
            // Check to see if this is the current country, if not we need to redirect
            if ((NeonLocale::getUrlPrefix() != $countryCode . '-' . $languageCode and NeonLocale::getUrlPrefix() != $countryCode) or !Request::segment(1)) {
                // Find the best locale based upon country and language
                if (isset($locales[$countryCode . '-' . $languageCode])) {
                    return redirect(NeonLocale::getAlternateUrl($countryCode . '-' . $languageCode));
                }

                if (isset($locales[$countryCode])) {
                    return redirect(NeonLocale::getAlternateUrl($countryCode));
                }

                if (isset($redirects[$countryCode])) {
                    return redirect(NeonLocale::getAlternateUrl($redirects[$countryCode]));
                }
            }
        }

        // If the locale really doesn't exist, we will find it...
        if (isset($record)) {
            $locale = \NeonLocale::getLocale($record->country->isoCode);
            return redirect(NeonLocale::getAlternateUrl($locale->getPrefix()));
        }
    }
}
