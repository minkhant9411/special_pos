<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Supplier;
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
            'customers' => $customers
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
    public function show(Sale $sale)
    {

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }
    public function history()
    {
        dd();
    }
}
