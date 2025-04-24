<?php

namespace App;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Route;

trait SharedFunctionality
{
    public function getCart($view, $for)
    {
        $search = request()->search;
        $category = request()->category;

        $categories = Category::where('is_deleted', false)
            ->whereIn('transaction_type', [$for, 'for_both'])
            ->get();

        $products = Product::where('is_deleted', false)
            ->whereHas('category', function ($query) use ($for) {
                $query->whereIn('transaction_type', [$for, 'for_both']);
            })
            ->when($search || $category, function ($query) use ($search, $category) {
                $query->where(function ($q) use ($search, $category) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }

                    if ($category) {
                        $q->orWhereHas('category', function ($catQuery) use ($category) {
                            $catQuery->where('name', $category);
                        });
                    }
                });
            })
            ->with('category')
            ->get();
        return inertia($view, [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    public function getData(Request $request)
    {
        // $request->date ? $date = Carbon::parse($request->date) : $date = Carbon::today('Asia/Yangon');

        //sale
        $totalSaleAmount = Sale::when(
            $request->search,
            function ($query, $search) {
                $query->where('voucher_id', $search);
            }
        )->when($request->date, function ($query, $date) {
            $query->whereDate('date', Carbon::parse($date));
        })
            ->sum('paid');

        $sales = Sale::where('is_deleted', false)->with(['products', 'customer'])->when($request->search, function ($query, $search) {
            $query->where('voucher_id', $search);
        })->when($request->date, function ($query, $date) {
            $query->whereDate('date', Carbon::parse($date));
        })->get();

        //purchase
        $totalPurchaseAmount = Purchase::when(
            $request->search,
            function ($query, $search) {
                $query->where('voucher_id', $search);
            }
        )->when($request->date, function ($query, $date) {
            $query->whereDate('date', Carbon::parse($date));
        })
            ->sum('paid');

        $purchases = Purchase::where('is_deleted', false)->with(['products', 'supplier'])
            ->when($request->search, function ($query, $search) {
                $query->where('voucher_id', $search);
            })
            ->when($request->date, function ($query, $date) {
                $query->whereDate('date', Carbon::parse($date));
            })->get();


        if ($request->uri()->path() == Route::getRoutes()->getByName('home')->uri()) {
            return (object) [
                'totalSaleAmount' => $totalSaleAmount,
                'totalPurchaseAmount' => $totalPurchaseAmount
            ];
        }

        if ($request->uri()->path() == Route::getRoutes()->getByName('sale.history')->uri()) {
            return (object) [
                'sales' => $sales,
                'totalAmount' => $totalSaleAmount
            ];
        }

        if ($request->uri()->path() == Route::getRoutes()->getByName('purchase.history')->uri()) {
            return (object) [
                'purchases' => $purchases,
                'totalAmount' => $totalPurchaseAmount
            ];
        }


    }
}
