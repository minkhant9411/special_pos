<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Carbon\Carbon;
use Date;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::where('is_deleted', false)->get();
        $purchases = Purchase::where('is_deleted', false)->get();
        return Inertia('History/Index', [
            'sales' => $sales,
            'purchases' => $purchases
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }
    public function sale(Request $request)
    {
        $request->date ? $date = $request->date : $date = Carbon::today('Asia/Yangon');
        $today = Carbon::today('Asia/Yangon');
        $sales = Sale::where('is_deleted', false)->with(['products', 'customer'])->get();
        $totalAmount = Sale::whereDate('date', $today)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->whereDate('date', $date)
            ->sum('paid');
        return Inertia('Sale/Show', [
            'sales' => $sales,
            'totalAmount' => $totalAmount,
            'items' => ''
        ]);
    }
    public function product(Request $request)
    {
        $request->date ? $date = $request->date : $date = Carbon::today('Asia/Yangon');
        $products = Product::where('is_deleted', false)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->with([
                'sales' => function ($q, ) use ($date) {
                    $q->whereDate('date', Carbon::parse($date));
                }
            ])->paginate(10)->withQueryString();
        $grand_total = $products->map(function ($product) {
            $total = $product->sales->sum(function ($sale) {
                return $sale->pivot->price * $sale->pivot->quantity;
            });
            $total_quantity = $product->sales->sum(function ($sale) {
                return $sale->pivot->quantity;
            });
            return [
                'id' => $product->id,
                'total_price' => $total,
                'total_quantity' => $total_quantity
            ];

        });
        return Inertia('History/Product', [
            'products' => inertia()->merge(fn() => $products->items()),
            'productPagination' => $products->toArray(),
            'grand_total' => inertia()->merge(fn() => $grand_total)

        ]);
    }
}
