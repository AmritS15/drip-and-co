<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    
    public function show($order_id, $item_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->firstOrFail();

        
        if ($order->status !== 'delivered') {
            return redirect()->route('user.order.details', $order_id)
                ->with('error', 'Returns can only be requested for delivered orders.');
        }

        $item = OrderItem::where('order_id', $order->id)->where('id', $item_id)->firstOrFail();

        
        if ($item->rstatus) {
            return redirect()->route('user.order.details', $order_id)
                ->with('error', 'This item has already been returned.');
        }

        return view('user.return-request', compact('order', 'item'));
    }

    
    public function store(Request $request, $order_id, $item_id)
    {
        $request->validate([
            'return_reason' => 'required|string|max:500',
        ]);

        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->firstOrFail();

        if ($order->status !== 'delivered') {
            return redirect()->route('user.order.details', $order_id)
                ->with('error', 'Returns can only be requested for delivered orders.');
        }

        $item = OrderItem::where('order_id', $order->id)->where('id', $item_id)->firstOrFail();

        if ($item->rstatus) {
            return redirect()->route('user.order.details', $order_id)
                ->with('error', 'This item has already been returned.');
        }

        
        $product = Product::find($item->product_id);
        if ($product) {
            $product->quantity += $item->quantity;
            
            if ($product->stock_status === 'outofstock' && $product->quantity > 0) {
                $product->stock_status = 'instock';
            }
            $product->save();
        }

        
        $item->rstatus = true;
        $item->return_reason = $request->return_reason;
        $item->return_date = Carbon::today();
        $item->save();

        
        $allReturned = OrderItem::where('order_id', $order->id)->where('rstatus', false)->doesntExist();
        if ($allReturned) {
            $order->return_date = Carbon::today();
            $order->save();
        }

        return redirect()->route('user.order.details', $order_id)
            ->with('status', 'Return request submitted successfully. Your stock has been restored.');
    }
}
