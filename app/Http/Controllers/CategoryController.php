<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_deleted', false)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })->get();
        return inertia('Category/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia('Category/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'transaction_type' => 'required|in:for_sale,for_purchase,for_both',
        ]);

        // Category::create($request->all());
        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'transaction_type' => $request->transaction_type,
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('category.index')->with('message', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return inertia('Category/Edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);
        // $category = Category::find($id);
        $category->fill($validate);
        if ($category->isClean()) {
            return redirect()->route('category.index')->with('message', 'No changes made.');
        }
        $category->name = $request->name;
        $category->description = $request->description;
        $category->updated_by = auth()->user()->id;
        $category->save();
        return redirect()->route('category.index')->with('message', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category, $id)
    {
        $category = Category::find($id);
        $category->is_deleted = true;
        $category->save();
        return redirect()->route('category.index')->with('message', 'Category deleted successfully.');
    }
}
