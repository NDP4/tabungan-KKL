<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    private array $rolePermissions = [
        'mahasiswa' => [
            'savings.create',
            'savings.view-own',
            'profile.edit',
        ],
        'bendahara' => [
            'savings.create',
            'savings.view-all',
            'savings.approve',
            'savings.reject',
            'expenses.create',
            'expenses.approve',
            'reports.view',
            'reports.generate',
            'profile.edit',
        ],
        'panitia' => [
            'savings.view-all',
            'expenses.create',
            'expenses.approve',
            'reports.view',
            'profile.edit',
            'users.manage',
            'users.edit-role',
            'users.create',
            'users.delete'
        ]
    ];

    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $userRole = $request->user()->role;

        if (!isset($this->rolePermissions[$userRole])) {
            abort(403, 'Invalid role.');
        }

        if (!in_array($permission, $this->rolePermissions[$userRole])) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
