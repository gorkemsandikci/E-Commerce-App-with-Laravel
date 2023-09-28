<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Invoice::withCount('orders')->paginate(10);
        return view('backend.pages.order.index', compact('orders'));
    }

    public function edit(string $id)
    {
        $order = Invoice::where('id', $id)->first();
        return view('backend.pages.order.edit', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        //*
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $order = Invoice::where('id', $request->id)->firstOrFail();
        Order::where('order_no', $order->order_no)->delete();
        $order->delete();
        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->state;
        $update_check = $update == "false" ? '0' : '1';

        Invoice::where('id', $request->id)->update(['status' => $update_check]);
        return response(['error' => false, 'status' => $update]);
    }
}
