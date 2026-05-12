<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

/**
 * Aligne l’URL racine des liens (route(), url()) avec l’URL réelle du navigateur.
 * Utile si APP_URL ne correspond pas (ex. app dans un sous-dossier Apache).
 */
class ForceApplicationUrl
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->runningInConsole()) {
            $root = rtrim($request->getSchemeAndHttpHost().$request->getBaseUrl(), '/');
            if ($root !== '') {
                URL::forceRootUrl($root);
            }
        }

        return $next($request);
    }
}
