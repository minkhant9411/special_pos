<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Services\VoucherService;
use App\SharedFunctionality;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    use SharedFunctionality;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->getCart('Purchase/Index', 'for_purchase');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $suppliers = Supplier::where('is_deleted', '=', false)->get();
        return Inertia('Purchase/Cart', [
            'suppliers' => $suppliers,
            'voucher_id' => 'P-' . VoucherService::generate()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'products' => 'required|array',
            'voucher_id' => 'unique:purchases,voucher_id|required',
            'date' => 'date|required',
            'description' => 'nullable|string',
            'paid' => 'numeric|required',
            'supplier_id' => 'nullable|numeric|exists:suppliers,id'
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
