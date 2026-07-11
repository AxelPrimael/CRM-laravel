<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        // ADMIN a tout
        if ($user->role === 'admin') {
            return $next($request);
        }

        // USER normal → permissions simples
        $permissions = [
            'user' => [
                'contact.view',
                'contact.create',
            ]
        ];

        if (!in_array($permission, $permissions[$user->role] ?? [])) {
            abort(403, 'Permission refusée');
        }

        return $next($request);
    }
}