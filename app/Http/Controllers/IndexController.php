<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;

class IndexController extends Controller
{
public function indexall(){


$nn=Product::with(['colors','sizes','images'])->get();
return response()->json(['msg'=>$nn]);
}



}
