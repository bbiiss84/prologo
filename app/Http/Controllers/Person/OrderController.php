<?php

namespace App\Http\Controllers\Person;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
	{
		$orders =Auth::user()->orders()->active()->paginate(10);
		return view('auth.orders.index', ['orders' => $orders]);
	}

	public function show($id)
	{
		$order =Order::where('id', $id)->first();
        if(!Auth::user()->orders->contains($order)) {
			return back();
		}
		return view('auth.orders.show', ['order' => $order]);
	}
}
