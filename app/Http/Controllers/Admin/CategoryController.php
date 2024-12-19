<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('admin_id', Auth('admin')->id())->get();
        return view('admin.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->admin_id = Auth('admin')->id();
        $category->save();

        return redirect()->route('categories.index')->with('success', 'تم إنشاء الفئة بنجاح');
    }

    public function show(Category $category)
    {
        $category = Category::with('subs')->find($category->id);
        return view('admin.categories.show',compact('category'));
    }

    public function destroy(Category $category)
    {
        $category = Category::find($category->id);
        if($category->admin_id != Auth('admin')->id()){
            return redirect()->route('categories.index')->with('error', 'غير مسموح لك بحذف هذه الفئة');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'تم حذف الفئة بنجاح');
    }
}
