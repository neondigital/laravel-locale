<?php

namespace Neondigital\LaravelLocale\Middleware;

use Closure;
use Config;
use Locale;
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
        }

        // Do we have this country set-up?
        $locales = Config::get('locale.locales', []);
        $redirects = Locale::getRedirects();

        if (isset($locales[$countryCode]) or isset($locales[$countryCode . '-' . $languageCode]) or isset($redirects[$countryCode])) {
            // Check to see if this is the current country, if not we need to redirect
            if ((Locale::getUrlPrefix() != $countryCode . '-' . $languageCode and Locale::getUrlPrefix() != $countryCode) or !Request::segment(1)) {
                // Find the best locale based upon country and language
                
                if (isset($locales[$countryCode . '-' . $languageCode])) {
                    return redirect(Locale::getAlternateUrl($countryCode . '-' . $languageCode));
                }

                if (isset($locales[$countryCode])) {
                    return redirect(Locale::getAlternateUrl($countryCode));
                }

                if (isset($redirects[$countryCode])) {
                    return redirect(Locale::getAlternateUrl($redirects[$countryCode]));
                }
            }
        }

        return return redirect(Locale::getAlternateUrl(Config::get('locale.default')));
    }
}
