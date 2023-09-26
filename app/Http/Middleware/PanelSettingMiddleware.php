<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PanelSettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = SiteSetting::
        pluck('data', 'name')->toArray();

        view()->share(['settings' => $settings]);

        return $next($request);
    }
}
