<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect('login');
        }

        foreach ($roles as $role) {
            if ($user->role->name === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
