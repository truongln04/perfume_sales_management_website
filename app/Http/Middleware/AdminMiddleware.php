<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login')
                ->with('error', 'Vui lòng đăng nhập!');
        }

        $userRole = strtolower(trim(Auth::user()->vai_tro));

        $roles = array_map(function ($role) {
            return strtolower(trim($role));
        }, $roles);

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        return redirect()->route('admin.dashboard')
        ->with('error', 'Bạn không có quyền truy cập!');
    }
}
