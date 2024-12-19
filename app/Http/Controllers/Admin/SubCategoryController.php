<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;

class SubCategoryController extends Controller
{
    public function index($category_id)
    {
        $category = Category::find($category_id);
        if (!$category || $category->admin_id !== auth('admin')->id()) {
            return response()->json('غير مصرح', 403);
        }
        $subs = $category->subs();
        return view('Admin.subs.index', compact('subs'));
    }

    public function create()
    {
        $categories = Category::where('admin_id', auth()->id())->get();
        return view('Admin.subs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);
    
        SubCategory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
        ]);
    
        return redirect()->back()->with('success', 'تم إنشاء الفئة الفرعية بنجاح.');
    }
    
    public function destroy($id)
    {
        $sub = SubCategory::findOrFail($id);
    
        if ($sub->category->admin_id !== auth('admin')->id()) {
            return redirect()->back()->with('error', 'غير مسموح لك بحذف هذه الفئة الفرعية');
        }
    
        $sub->delete();
    
        return redirect()->back()->with('success', 'تم حذف الفئة الفرعية بنجاح.');
    }
    

    public function show($id)
    {
        $sub = SubCategory::with('products')->findOrFail($id);
        return view('Admin.subs.show', compact('sub'));
    }
}
