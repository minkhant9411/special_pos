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
        $sales = Sale::get();
        $purchases = Purchase::get();
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
        $request->date ? $date = Carbon::parse($request->date) : $date = Carbon::today('Asia/Yangon');
        $request->is_sale == null || $request->is_sale === 'true' ? $is_sale = true : $is_sale = false;
        // dd($is_sale);
        // dd($date);
        if ($is_sale) {
            $products = Product::when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
                ->with([
                    'sales' => function ($q) use ($date) {
                        $q->whereDate('date', $date)
                        ;
                    }
                ])
                ->with([
                    'category' => function ($q) {
                        $q;
                    }
                ])
                ->paginate(20)->withQueryString();
        } else {
            $products = Product::when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
                ->with([
                    'purchases' => function ($q) use ($date) {
                        $q->whereDate('date', $date)
                        ;
                    }
                ])
                ->with([
                    'category' => function ($q) {
                        $q;
                    }
                ])
                ->paginate(20)->withQueryString();
        }
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
<<<<<<< HEAD
=======
    public function customer(Request $request)
    {

        $customer = Customer::where('id', $request->id)
            ->with([
                'sales' => function ($query) {
                    $query;

                }
            ])
            ->first();
        if (!$request->isBoard) {
            $customer = $customer->sales->map(function ($sale) {
                return [
                    'date' => $sale->created_at,
                    'voucher_id' => $sale->voucher_id,
                    'paid' => $sale->paid,
                    'total' => $sale->vinyls->sum(function ($vinyl) {
                        return $vinyl->length * $vinyl->width * $vinyl->pivot->price * $vinyl->pivot->quantity;
                    })
                ];
            });
            $customer = $customer->filter(function ($c) {
                return str_starts_with($c['voucher_id'], 'V-') && $c['paid'] != $c['total'];
            });
        } else {
            $customer = $customer->sales->map(function ($sale) {
                return [
                    'date' => $sale->created_at,
                    'voucher_id' => $sale->voucher_id,
                    'paid' => $sale->paid,
                    'total' => $sale->boards->sum(function ($board) {
                        return $board->length * $board->width * $board->pivot->price * $board->pivot->quantity;
                    })
                ];
            });

            $customer = $customer->filter(function ($c) {
                return str_starts_with($c['voucher_id'], 'B-') && $c['paid'] != $c['total'];
            });
        }

        return $customer;

    }

>>>>>>> 7f9bd50 (add notDeletedScope)
}
