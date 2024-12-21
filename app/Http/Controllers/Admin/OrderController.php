<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Orders::orderByRaw("FIELD(status, 'قيد الانتظار', 'تم الموافقة', 'تم التوصيل')")->paginate(20);
        return view('Admin.orders.index', compact('orders'));
    }

    public function acceptOrder($id)
    {
        $order = Orders::find($id);
        $order->status = 'تم الموافقة';
        $order->save();
        return redirect()->back()->with('success', 'تم الموافقة على الطلب');
    }
    public function rejectOrder($id)
    {
        $order = Orders::find($id);
        $order->status = 'تم الرفض';
        $order->delete();
        return redirect()->back()->with('success', 'تم رفض الطلب و حذفه');
    }

    public function deliveryOrder($id)
    {
        $order = Orders::find($id);
        $order->status = 'تم التوصيل';
        $order->save();
        return redirect()->back()->with('success', 'تم توصيل الطلب');
    }

}
