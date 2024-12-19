<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\product\store;
use App\Http\Requests\product\update;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Color;
use App\Models\Size;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['colors', 'sizes', 'subcategory'])->get();
        return view('Admin.products.index', compact('products'));
    }

    public function create()
    {
        $subcategories = SubCategory::all();
        $colors = Color::all();
        $sizes = Size::all();

        return view('Admin.products.create', compact('subcategories', 'colors', 'sizes'));
    }

    public function store(store $request)
{
    $validatedData = $request->validated();
    
    $product = Product::create($request->except(['colors', 'sizes', 'images']));
    $product->colors()->sync($validatedData['colors']);
    $product->sizes()->sync($validatedData['sizes']);
    
    if ($request->has('images')) {
        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('products', 'public');
            $product->images()->create([
                'image_url' => $imagePath,
            ]);

        }
        // $product->images()->sync($validatedData['images']);

    }
    
    return redirect()->route('products.index')->with('success', 'Product added successfully.');
}

    

    public function edit(Product $product, $productId)
    {

        $product = Product::with('colors','sizes')->findOrFail($productId);
        $subcategories = SubCategory::all();
        $colors = Color::all();
        $sizes = Size::all();
    
        return view('Admin.products.edit', compact('product', 'subcategories', 'colors', 'sizes'));
    }
    
    public function update(update $request, $productId)
{
    
    $product = Product::findOrFail($productId);
    $data = $request->only(['brand', 'title', 'description', 'quantity', 'subcategory_id', 'price']);
    $product->update($data);
    $product->colors()->sync($request->colors);
    $product->sizes()->sync($request->sizes);

    return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح.');
}


    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
