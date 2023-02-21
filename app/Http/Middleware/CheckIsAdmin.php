<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user(); // Используем фасад Auth. Это некий статичный класс.

		if (!$user->isAdmin()) {
			session()->flash('warning', 'У Вас нет прав администратора');
			return redirect()->route('index');
		}

        return $next($request);
    }
}
