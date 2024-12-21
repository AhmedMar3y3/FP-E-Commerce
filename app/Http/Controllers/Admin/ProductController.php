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

    public function show(Product $product)
    {
        $product = Product::with(['colors', 'sizes', 'subcategory'])->findOrFail($product->id);
        return view('Admin.products.show', compact('product'));
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
    
        if ($request->is_on_sale && (!$request->sale_price || $request->sale_price >= $request->price)) {
            return redirect()->back()->withErrors(['sale_price' => 'Sale price must be less than the original price.']);
        }
    
        $product = Product::create($request->except(['colors', 'sizes', 'images']));
        $product->colors()->sync($validatedData['colors']);
        $product->sizes()->sync($validatedData['sizes']);
    
        // Handle images
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $imagePath = $image->store('products', 'public');
                    $product->images()->create([
                        'image_url' => $imagePath,
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                }
            }
        }
    
        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح.');
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
    
        if ($request->is_on_sale && (!$request->sale_price || $request->sale_price >= $request->price)) {
            return redirect()->back()->withErrors(['sale_price' => 'Sale price must be less than the original price.']);
        }
    
        $data = $request->only(['brand', 'title', 'description', 'quantity', 'price', 'is_on_sale', 'sale_price', 'subcategory_id']);
        $product->update($data);
        $product->colors()->sync($request->colors);
        $product->sizes()->sync($request->sizes);
    
        // Handle images
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                try {
                    $imagePath = $image->store('products', 'public');
                    $product->images()->create([
                        'image_url' => $imagePath,
                    ]);
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['error' => $e->getMessage()]);
                }
            }
        }
    
        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج بنجاح.');
    }
    

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
