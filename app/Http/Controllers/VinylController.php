<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use App\Models\Vinyl;
use App\Services\VoucherService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VinylController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->date ? $date = Carbon::parse($request->date) : $date = Carbon::today('Asia/Yangon');


        $customers = Customer::where('is_deleted', false)
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->with([
                'sales' => function ($query) use ($date) {
                    $query
                        ->where('voucher_id', 'like', 'V-%')
                        ->whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month);
                }
            ], [
                'sales.vinyls' => function ($query) use ($date) {
                    $query
                        ->where('voucher_id', 'like', 'V-%')->whereYear('vinyls.created_at', $date->year)
                        ->whereMonth('vinyls.created_at', $date->month);
                }
            ])
            ->get();
        $customersData = $customers->map(function ($customer) {
            // Sum of "paid" field from sales
            $totalPaid = $customer->sales->sum('paid');

            // Sum of (length * width) from all vinyls in all sales
            $totalFeet = $customer->sales->flatMap(function ($sale) {
                return $sale->vinyls;
            })->sum(function ($vinyl) {
                return $vinyl->length * $vinyl->width * $vinyl->pivot->quantity;
            });

            return [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'totalpaid' => $totalPaid,
                'totalfeet' => $totalFeet
            ];
        });
        $vinyls = Vinyl::where('is_deleted', false)
            ->when($request->search, function ($query) use ($request) {
                $query->where('customers_id', '=', $request->search);
            })
            ->where(function ($query) use ($date) {
                // dd($date->year, $date->month);
                $query->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month);
            })
            ->with('customer');
        $vinyls = $vinyls
            ->paginate(20)->withQueryString();


        // dd($vinyls->toArray());
        return Inertia('Vinyl/Index', [
            'vinyls' => inertia()->merge(fn() => $vinyls->items()),
            'vinylPagination' => $vinyls->toArray(),
            'customers' => Customer::where('is_deleted', false)->get(),
            'customersData' => $customersData,

        ]);
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
