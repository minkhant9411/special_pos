<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\SharedFunctionality;
use Carbon\Carbon;
use Date;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HistoryController extends Controller
{
    use SharedFunctionality;

    public function index()
    {
        $sales = Sale::where('is_deleted', false)->get();
        $purchases = Purchase::where('is_deleted', false)->get();
        return Inertia('History/Index', [
            'sales' => $sales,
            'purchases' => $purchases
        ]);
    }

    public function sale(Request $request)
    {
        $data = $this->getData($request);
        return Inertia('Sale/Show', [
            'sales' => $data->sales,
            'totalAmount' => $data->totalAmount
        ]);
    }
    public function purchase(Request $request)
    {
        $data = $this->getData($request);
        return Inertia('Purchase/Show', [
            'purchases' => $data->purchases,
            'totalAmount' => $data->totalAmount
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
            ])
            ->with([
                'purchases' => function ($q, ) use ($date) {
                    $q->whereDate('date', Carbon::parse($date));
                }
            ])
            ->paginate(10)->withQueryString();
        $grand_total = $products->map(function ($product) {
            $sale_total = $product->sales->sum(function ($sale) {
                return $sale->pivot->price * $sale->pivot->quantity;
            });
            $sale_total_quantity = $product->sales->sum(function ($sale) {
                return $sale->pivot->quantity;
            });
            $purchase_total = $product->purchases->sum(function ($purchase) {
                return $purchase->pivot->price * $purchase->pivot->quantity;
            });
            $purchase_total_quantity = $product->purchases->sum(function ($purchase) {
                return $purchase->pivot->quantity;
            });

            return [
                'id' => $product->id,
                'sale_total_price' => $sale_total,
                'purchase_total_price' => $purchase_total,
                'sale_total_quantity' => $sale_total_quantity,
                'purchase_total_quantity' => $purchase_total_quantity
            ];
        });
        // dd($grand_total);
        return Inertia('History/Product', [
            'products' => inertia()->merge(fn() => $products->items()),
            'productPagination' => $products->toArray(),
            'grand_total' => inertia()->merge(fn() => $grand_total)

        ]);
    }
}
