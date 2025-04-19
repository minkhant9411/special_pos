<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::where('is_deleted', false)
            ->when(request()->search || request()->category, function ($query) {
                $query->where(function ($q) {
                    if (request()->search) {
                        $q->where('name', 'like', '%' . request()->search . '%');
                    }
                    if (request()->category) {
                        $q->orWhereHas('category', function ($catQuery) {
                            $catQuery->where('name', request()->category);
                        });
                    }
                });
            })
            ->with('category')
            ->get();
        // dd($products);
        $categories = Category::where('is_deleted', false)->get();
        return Inertia::render('Product/Index', [
            'products' => $products,
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_deleted', '=', false)->get();
        return Inertia::render('Product/Create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $img_url = Storage::disk('public')->put('product_image', $request->image);
        }
        $product = Product::create([
            'name' => $validate['name'],
            'image_path' => $img_url ?? null,
            'category_id' => $validate['category_id'],
            'description' => $validate['description'],
            'cost_price' => $validate['cost_price'],
            'price' => $validate['price'],
            'unit' => $validate['unit'],
            'created_by' => auth()->user()->id,
        ]);
        return redirect()->route('product.index')->with('message', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::where('is_deleted', '=', false)->get();
        return Inertia::render('Product/Edit', [
            'categories' => $categories,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request->all());

        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:255',
        ]);

        $product->fill($validate);
        if ($product->isClean() && $validate['image'] == null) {
            return redirect()->route('product.index')->with('message', 'Nothing has been changed.');
        }
        if ($request->hasFile('image')) {
            $request->image != null ?? Storage::disk('public')->delete($product->image_path);
            $img_url = Storage::disk('public')->put('product_image', $request->image);
        }
        $product->update([
            'name' => $validate['name'],
            'image_path' => $img_url ?? $product->image_path,
            'category_id' => $validate['category_id'],
            'description' => $validate['description'],
            'cost_price' => $validate['cost_price'],
            'price' => $validate['price'],
            'unit' => $validate['unit'],
        ]);
        return redirect()->route('product.index')->with('message', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        $product = Product::find($id);
        $product->is_deleted = true;
        $product->save();
        return redirect()->route('product.index')->with('message', 'Product deleted successfully.');


    }
}
