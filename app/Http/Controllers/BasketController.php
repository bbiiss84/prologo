<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class BasketController extends Controller
{
    public function basket()
    {
        $orderId = session('orderId');
        if (!is_null($orderId)) {
            $order = Order::findOrFail($orderId);
        }

        return view('basket', ['order' => $order]);
    }

    public function basketPlace()
    {
        return view('order');
    }

    public function basketAdd($productId)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else {
            $order = Order::find($orderId);
        }

        if ($order->products->contains($productId)) { // Проверяем есть ли такой товар в корзине
            $pivotRow = $order->products()
                ->where('product_id', $productId)
                ->first()
                ->pivot; // Получаем доступ к полям таблицы (для данного товара)
            $pivotRow->count++; // Увеличиваем счетчик
            $pivotRow->update(); // Обновляем поля
        } else {
            $order->products()->attach($productId); // Если товара еще не было в корзине, добавляем
        }

        return to_route('basket');
    }

    public function basketRemove($productId)
    {
        $orderId = session('orderId');
        $order = Order::find($orderId);

        if (is_null($orderId)) {
            return view('basket');
        }

        $order = Order::find($orderId);

        if ($order->products->contains($productId)) { // Проверяем есть ли такой товар в корзине
            $pivotRow = $order->products()
                ->where('product_id', $productId)
                ->first()
                ->pivot; // Получаем доступ к полям таблицы (для данного товара)
            if ($pivotRow->count < 2) {
                $order->products()->detach($productId); // Если такой товар в корзине один, удаляем его
            } else {
                $pivotRow->count--; // Уменьшаем счетчик
                $pivotRow->update(); // Обновляем поля
            }
        }

        return to_route('basket');
    }
}
