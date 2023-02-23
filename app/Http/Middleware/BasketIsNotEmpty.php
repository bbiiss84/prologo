<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;


class BasketIsNotEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
	{
		$orderId = session('orderId');

		if (!is_null($orderId) && Order::getFullSum() > 0) { // Проверяем, что заказ существует и стоимость больше нуля
			return $next($request);
		}

		session()->flash('warning', 'Ваша корзина пуста');
		return to_route('index'); // Редиректит на главную страницу
	}
}
