<?php

namespace Neondigital\LaravelLocale\Middleware;

use Closure;

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
        $action['prefix'] = \Locale::getUrlPrefix();

        if (!$action['prefix']) {
            abort(404);
        }

        $request->route()->setAction($action);

        return $next($request);
    }
}