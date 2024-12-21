<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Color;
use App\Models\Orders;
use App\Models\Size;
use App\Http\Requests\CreateOrder;

class OrdersController extends Controller
{
    //_____________________________________________________________________________________________________
    public function index()
    {
        $user = Auth::user();
        $orders = Orders::where('user_id', $user->id)->get();

        return response()->json(['orders' => $orders]);
    }
    //____________________________________________________________________________________________________________
    public function store(CreateOrder $request)
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = Auth::id(); 
        $order = Orders::create($validatedData);

        return response()->json(['msg' => 'Order created successfully', 'order' => $order]);
    }
    //____________________________________________________________________________________________________________
    public function destroy(string $id)
    {
        $order = Orders::findOrFail($id);

        if ($order->user_id !== Auth::id()) {
            return response()->json(['msg' => 'Unauthorized']);
        }

        $order->delete();

        return response()->json(['msg' => 'Order deleted successfully']);
    }
}
