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
        $search = request()->search;
        $category = request()->category;

        $categories = Category::where('is_deleted', false)
            ->whereIn('transaction_type', ['for_purchase', 'for_both'])
            ->get();

        $products = Product::where('is_deleted', false)
            ->whereHas('category', function ($query) {
                $query->whereIn('transaction_type', ['for_purchase', 'for_both']);
            })
            ->when($search || $category, function ($query) use ($search, $category) {
                $query->where(function ($q) use ($search, $category) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }

                    if ($category) {
                        $q->orWhereHas('category', function ($catQuery) use ($category) {
                            $catQuery->where('name', $category);
                        });
                    }
                });
            })
            ->with('category')
            ->get();
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
            'voucher_id' => 'unique:purchases,voucher_id|required',
            'date' => 'date|required',
            'description' => 'nullable|string',
            'paid' => 'integer|required',
            'supplier_id' => 'nullable|numeric|exist:suppliers,id'
        ]);
        // dd($validate);
        $purchase = Purchase::create([
            'voucher_id' => $validate['voucher_id'],
            'date' => $validate['date'],
            'description' => $validate['description'],
            'paid' => $validate['paid'],
            'supplier_id' => $validate['supplier_id'],
            'created_by' => auth()->user()->id,
        ]);
        foreach ($request->products as $product) {
            $pivotData[$product['product_id']] = [
                'quantity' => $product['qty'],
                'price' => $product['price'],
            ];
        }

        $purchase->products()->attach($pivotData);
        return redirect()->route('purchase.index')->with('message', 'Purchase created successfully.');
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
