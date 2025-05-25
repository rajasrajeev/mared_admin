<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SharePermissions
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $permissions = $user->userRole->permissions ?? [];
            view()->share('permissions', $permissions);
        }

        return $next($request);
    }
}