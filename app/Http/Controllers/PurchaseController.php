<?php

namespace App\Http\Controllers;

use App;
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
    public function show($id)
    {
        $purchase = Purchase::where('voucher_id', $id)->where('is_deleted', '=', false)->with(['products', 'supplier'])->first();
        $grand_total = $purchase->products->map(function ($product) {
            return ['total' => $product->pivot->price * $product->pivot->quantity];
        })->sum('total');
        $products = Product::where('is_deleted', '=', false)->get();

        return Inertia('Purchase/Detail', ['purchase' => $purchase, 'grand_total' => $grand_total, 'products' => $products]);
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
        if ($request->has('delete')) {
            $purchase->products()->detach($request->product_id);
            return redirect()->back()->with('message', 'Product removed successfully.');
        }
        if ($request->has('paid') && $request->paid_only) {
            $request->validate([
                'paid' => 'numeric|required|min:0',
            ]);
            $purchase->paid = $request->paid;
            $purchase->save();
            return redirect()->back()->with('message', 'Purchase updated successfully.');
        }
        $validate = $request->validate([
            'productId' => 'required|exists:products,id',
            "quantity" => 'required|numeric|min:1',
            "price" => 'required|numeric|min:1',
        ]);
        // Check if the product already exists in the pivot table
        $existingProduct = $purchase->products()->where('product_id', $validate['productId'])->exists();

        if ($existingProduct) {
            // Update the existing pivot record
            $purchase->products()->updateExistingPivot($validate['productId'], [
                'quantity' => $validate['quantity'],
                'price' => $validate['price'],
            ]);
        } else {
            // Attach the new product to the pivot table
            $purchase->products()->attach($validate['productId'], [
                'quantity' => $validate['quantity'],
                'price' => $validate['price'],
            ]);
        }

        $purchase->save();
        return redirect()->back()->with('message', 'Purchase updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $purchase = Purchase::find($id);
        if (!$purchase)
            return App::abort(404);
        $purchase->products()->detach();
        $purchase->is_deleted = true;
        $purchase->save();
        return redirect()->route('purchase.history')->with('message', 'Purchase deleted successfully.');
    }
}
