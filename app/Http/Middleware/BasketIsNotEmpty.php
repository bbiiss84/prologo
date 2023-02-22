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
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = session('orderId');
        if (!is_null($orderId)) { // Проверяем, что заказ существует
            $order = Order::findOrFail($orderId); // findOrFail() выдаст 404, если по айдишнику ничего не найдено
            if ($order->products->count() > 0) { // Если количество товаров в корзине > 0
                return $next($request);
            }
        }

        session()->flash('warning', 'Ваша корзина пуста');
        return to_route('index');
    }
}
