<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\User;
use App\Models\Orders;
use App\Http\Requests\createReview;



class ReviewsController extends Controller
{
//____________________________________________________________________________________________________________
public function store(createReview $request)
{
    $validatedData = $request->validated();
    $order= Orders::find($validatedData['order_id']);

    if ($order->status == 'تم التوصيل') {
        $review = Review::create($validatedData);
        return response()->json([
            'msg' => 'Review created successfully',$review]);
    }
    return response()->json([
        'msg' => 'error',
    ]);
}
//____________________________________________________________________________________________________________
    public function show(string $id)
    {
        $review=Review::findOrFail($id);
        return response()->json(['msg'=>$review]);
    }

//____________________________________________________________________________________________________________
    public function destroy(string $id)
    {
        $review=Review::findOrFail($id);
        return response()->json(['msg'=>'deleted successfully']);
    }
//___________________________________________________________________________________________________________
}
