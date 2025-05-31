<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Customer;
use App\Models\Sale;
use App\Services\VoucherService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BoardController extends Controller
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
            ->with(
                [
                    'sales' => function ($query) use ($date) {
                        $query
                            ->where('voucher_id', 'like', 'B-' . '%')
                            ->whereYear('created_at', $date->year)
                            ->whereMonth('created_at', $date->month);
                    }
                ],
                [
                    'sales.boards' => function ($query) use ($date) {
                        $query
                            ->where('voucher_id', 'like', 'B-' . '%')
                            ->whereYear('boards.created_at', $date->year)
                            ->whereMonth('boards.created_at', $date->month);
                    }
                ]
            )
            ->get();
        // dd($customers->map(function ($c) {
        //     return $c->sales->map(function ($s) {
        //         return $s->paid;
        //     });
        // })->toArray());
        $customersData = $customers->map(function ($customer) {
            // Sum of "paid" field from sales
            $totalPaid = $customer->sales->sum('paid');

            // Sum of (length * width) from all boards in all sales
            $totalFeet = $customer->sales->flatMap(function ($sale) {
                return $sale->boards;
            })->sum(function ($board) {
                return $board->length * $board->width;
            });

            return [
                'customer_id' => $customer->id,
                'customer_name' => $customer->name,
                'totalpaid' => $totalPaid,
                'totalfeet' => $totalFeet
            ];
        });
        // dd($customersData->toArray());
        $boards = Board::where('is_deleted', false)
            ->when($request->search, function ($query) use ($request) {
                $query->where('customers_id', '=', $request->search);
            })
            ->where(function ($query) use ($date) {
                // dd($date->year, $date->month);
                $query->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month);
            })
            ->with('customer');
        $boards = $boards
            ->paginate(20)->withQueryString();


        // dd($boards->toArray());
        return Inertia('Board/Index', [
            'boards' => inertia()->merge(fn() => $boards->items()),
            'boardPagination' => $boards->toArray(),
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
        return inertia('Board/Create', [
            'customers' => $customers,
            'voucher_id' => 'B-' . VoucherService::generate()
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
            $board = Board::where('width', $product['width'])
                ->where('length', $product['length'])
                ->first();
            if ($board) {
                $pivotData[$board->id] = ['quantity' => $product['quantity'], 'price' => $product['price']];
            } else {
                $board = Board::create([
                    'width' => $product['width'],
                    'length' => $product['length'],
                    'price' => $product['price'],
                    'created_by' => auth()->user()->id,
                ]);
                $pivotData[$board->id] = ['quantity' => $product['quantity'], 'price' => $product['price']];
            }
        }

        $sale->boards()->attach($pivotData);
        // dd($board);
        return redirect()->route('sale.show', $sale->voucher_id)->with('message', 'Board Sale created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        //
    }
}
