<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Vinyl;
use App\Services\VoucherService;
use Illuminate\Http\Request;

class VinylController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $customers = Customer::where('is_deleted', false)->get();
        return inertia('Vinyl/Create', [
            'customers' => $customers,
            'voucher_id' => 'V-' . VoucherService::generate()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'allItems' => 'required|array',
            'voucher_id' => 'unique:sales,voucher_id|required',
            'date' => 'date|required',
            'description' => 'nullable|string',
            'paid' => 'numeric|required',
            'customer_id' => 'exists:customers,id|numeric'
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
        $pivotData = [];
        foreach ($request->allItems as $product) {
            $vinyl = Vinyl::where('width', $product['width'])
                ->where('length', $product['length'])
                ->first();
            if ($vinyl) {
                $pivotData[$vinyl->id] = ['quantity' => $product['quantity'], 'price' => $product['price']];
            } else {
                $vinyl = Vinyl::create([
                    'width' => $product['width'],
                    'length' => $product['length'],
                    'price' => $product['price'],
                    'created_by' => auth()->user()->id,
                ]);
                $pivotData[$vinyl->id] = ['quantity' => $product['quantity'], 'price' => $product['price']];
            }
        }

        $sale->vinyls()->attach($pivotData);
        // dd($vinyl);
        return redirect()->route('sale.show', $sale->voucher_id)->with('message', 'Vinyl Sale created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vinyl $vinyl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vinyl $vinyl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vinyl $vinyl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vinyl $vinyl)
    {
        //
    }
}
