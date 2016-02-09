<?php

namespace Neondigital\LaravelLocale\Middleware;

use Closure;
use Locale;

class LocaleSet
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
        $action = $request->route()->getAction();
        $action['prefix'] = Locale::getUrlPrefix();

        if (!$action['prefix']) {
            abort(404);
        }

        if ($action['prefix'] != $request->segment(1)) {
            return redirect(Locale::getAlternateUrl($action['prefix']));
        }

        $request->route()->setAction($action);

        return $next($request);
    }
}
