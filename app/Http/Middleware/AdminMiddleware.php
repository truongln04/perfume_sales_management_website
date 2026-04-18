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
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            $role = strtolower(trim(Auth::user()->vai_tro));

            if (in_array($role, ['admin', 'nhanvien'])) {
                return $next($request);
            }
        }

        return redirect('/')
            ->with('error', 'Bạn không có quyền truy cập!');
    }
}
