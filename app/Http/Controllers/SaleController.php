<?php

namespace App\Http\Controllers;

use App;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use App\Services\VoucherService;
use App\SharedFunctionality;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    use SharedFunctionality;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->getCart('Sale/Index', 'for_sale');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_deleted', '=', false)->get();
        return Inertia('Sale/Create', [
            'customers' => $customers,
            'voucher_id' => 'S-' . VoucherService::generate()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'products' => 'required|array',
            'voucher_id' => 'unique:sales,voucher_id|required',
            'date' => 'date|required',
            'description' => 'nullable|string',
            'paid' => 'numeric|required',
            'customer_id' => 'exists:customers,id|nullable|numeric'
        ]);
        // dd($validate);
        $sale = Sale::create([
            'voucher_id' => $validate['voucher_id'],
            'date' => $validate['date'],
            'description' => $validate['description'],
            'paid' => $validate['paid'],
            'customer_id' => $validate['customer_id'],
            'created_by' => auth()->user()->id,
        ]);
        foreach ($request->products as $product) {
            $pivotData[$product['product_id']] = [
                'quantity' => $product['qty'],
                'price' => $product['price'],
            ];
        }

        $sale->products()->attach($pivotData);
        return redirect()->route('sale.index')->with('message', 'Sale created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::where('voucher_id', $id)->where('is_deleted', '=', false)->with(['products', 'customer'])->first();
        if (!$sale)
            return App::abort(404);
        $grand_total = $sale->products->map(function ($product) {
            return ['total' => $product->pivot->price * $product->pivot->quantity];
        })->sum('total');
        $products = Product::where('is_deleted', '=', false)->get();
        return Inertia('Sale/Detail', ['sale' => $sale, 'grand_total' => $grand_total, 'products' => $products]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        if ($request->has('delete')) {
            $sale->products()->detach($request->product_id);
            return redirect()->back()->with('message', 'Product removed successfully.');
        }
        if ($request->has('paid') && $request->paid_only) {
            $request->validate([
                'paid' => 'numeric|required|min:0',
            ]);
            $sale->paid = $request->paid;
            $sale->save();
            return redirect()->back()->with('message', 'Sale updated successfully.');
        }
        $validate = $request->validate([
            'productId' => 'required|exists:products,id',
            "quantity" => 'required|numeric|min:1',
            "price" => 'required|numeric|min:1',
        ]);
        // Check if the product already exists in the pivot table
        $existingProduct = $sale->products()->where('product_id', $validate['productId'])->exists();

        if ($existingProduct) {
            // Update the existing pivot record
            $sale->products()->updateExistingPivot($validate['productId'], [
                'quantity' => $validate['quantity'],
                'price' => $validate['price'],
            ]);
        } else {
            // Attach the new product to the pivot table
            $sale->products()->attach($validate['productId'], [
                'quantity' => $validate['quantity'],
                'price' => $validate['price'],
            ]);
        }

        $sale->save();
        return redirect()->back()->with('message', 'Sale updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        if (!$sale)
            return App::abort(404);
        $sale->products()->detach();
        $sale->is_deleted = true;
        $sale->save();
        return redirect()->route('sale.history')->with('message', 'Sale deleted successfully.');
    }
    public function history()
    {

    }
}
