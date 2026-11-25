<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {

 // USE with normal prefix admin path under the main website like: computex.test/admin/...
            // Check if the URL starts with 'admin' or use the route name
//            if ($request->is('admin') || $request->is('admin/*')) {
//                return route('admin.login.create');
//            }

 //////////////////////////////////////////////////////////////////////////////

// USE with subdomain because you removed admin refix from RouteServiceProvide
            // 1. Check if the request is on the admin subdomain
            if ($request->getHost() === 'admin.computex.test') {
                return route('admin.login.create');
            }
///////////////////////////////////////////////////////////////////////////////
            elseif ($request->is('checkout') || $request->is('checkout/*')) {
                return route('front.login.create');
            }
            elseif ($request->is('customer') || $request->is('customer/*')) {
                return route('front.login.create');
            }

            // Default for everyone else
            return route('front.home');
        }

        return null; // For JSON/API requests
    }


}
