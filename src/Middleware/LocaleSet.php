<?php

namespace Neondigital\LaravelLocale\Middleware;

use Closure;
use NeonLocale;

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
        if ($locale = session()->get('locale')) {
            NeonLocale::setCurrent($locale);
        }

        $action = $request->route()->getAction();
        $action['prefix'] = NeonLocale::getUrlPrefix();

        if (!$action['prefix']) {
            abort(404);
        }
        $request->route()->setAction($action);
        return $next($request);
    }
}
