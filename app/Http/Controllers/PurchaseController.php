<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('is_deleted', '=', false)->get();
        $products = Product::where('is_deleted', '=', false)
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
            })->with('category')->get();
        return inertia('Purchase/Index', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $suppliers = Supplier::where('is_deleted', '=', false)->get();
        return Inertia('Purchase/Cart', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'voucher_id' => 'unique|required',
            'date' => 'date|required',
            'description' => 'string|nullable',
            'paid' => 'integer|required',
            'supplier_id' => 'nullable|exist:suppliers,id'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
