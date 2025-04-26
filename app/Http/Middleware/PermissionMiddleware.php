<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    private array $rolePermissions = [
        'ketua' => ['approve_savings', 'view_reports', 'manage_expenses', 'manage_users'],
        'bendahara' => ['approve_savings', 'view_reports', 'manage_expenses'],
        'mahasiswa' => ['create_savings', 'view_own_savings'],
    ];

    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();

        if (!$user || !$this->hasPermission($user->role, $permission)) {
            abort(403, 'You do not have the required permission.');
        }

        return $next($request);
    }

    private function hasPermission(string $role, string $permission): bool
    {
        return in_array($permission, $this->rolePermissions[$role] ?? []);
    }
}
