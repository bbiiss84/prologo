<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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
        $orderId = session('orderId');

        if (is_null($orderId)) {
            return redirect()->route('index');
        }

        $order = Order::find($orderId);

        return view('order', ['order' => $order]);
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

        if ($order->products->contains($productId)) {
            $pivotRow = $order->products()
                ->where('product_id', $productId)
                ->first()
                ->pivot;
            $pivotRow->count++;
            $pivotRow->update();
        } else {
            $order->products()->attach($productId);
        }

        if (Auth::check()) { // Если авторизован
            $order->user_id = Auth::id(); // В заказе указываем id пользователя
            $order->save();
        }

        $product = Product::find($productId);
        session()->flash('success', 'Добавлен товар ' . $product->name);

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

        if ($order->products->contains($productId)) {
            $pivotRow = $order->products()
                ->where('product_id', $productId)
                ->first()
                ->pivot;
            if ($pivotRow->count < 2) {
                $order->products()->detach($productId);
            } else {
                $pivotRow->count--;
                $pivotRow->update();
            }
        }

        $product = Product::find($productId);
        session()->flash('warning', 'Удален товар ' . $product->name);

        return to_route('basket');
    }

    public function basketConfirm(Request $request)
    {
        $orderId = session('orderId');
        if (is_null($orderId)) {
            return to_route('index');
        }

        $order = Order::find($orderId);
        $success = $order->saveOrder($request->name, $request->phone);

        if ($success) {
            session()->flash('success', 'Ваш заказ принят в обработку!');
        } else {
            session()->flash('warning', 'Произошла ошибка');
        }

        return to_route('index');
    }
}
