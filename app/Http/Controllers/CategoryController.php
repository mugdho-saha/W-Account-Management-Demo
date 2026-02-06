<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('created_at', 'desc')->paginate(50);
        return view('category.index', compact('categories'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
        ]);
        Category::create($validated);
        return redirect('/category')->with('success', 'Category created!');
    }

    public function edit(Category $category){
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $validated = $request->validate([
            // The unique rule needs to ignore the current category_id
            'category_name' => 'required|string|max:255|unique:categories,category_name,' . $category->category_id . ',category_id',
            'status'        => 'required|in:active,inactive',
        ]);

        $category->update($validated);
        return redirect('/category')->with('success', 'Category updated!');
    }

    public function destroy(Category $category){
        $category->delete();
        return redirect('/category')->with('success', 'Category deleted!');
    }
}
