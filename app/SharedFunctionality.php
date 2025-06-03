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

        $categories = Category::whereIn('transaction_type', [$for, 'for_both'])->latest()
            ->get();

        $products = Product::latest()
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
    public function generateSequencedVoucher()
    {
        $prefix = 'VOUCH';
        $date = now()->format('Ymd');
        $sequence = $this->getNextSequenceNumber();

        return "{$prefix}-{$date}-" . str_pad($sequence, 6, '0', STR_PAD_LEFT);
    }

    protected function getNextSequenceNumber()
    {
        // Implement database sequence or counter
        return \DB::table('vouchers')->count() + 1;
    }


    public function getData(Request $request)
    {
        $request->date ? $date = $request->date : $date = Carbon::today('Asia/Yangon');
        // if ($request->date && $request->search)
        //     dd('get');
        //sale
        $totalSaleAmount = Sale::when(
            $request->search,
            function ($query, $search) {
                $query->where('voucher_id', $search);
            }
        )->whereDate('date', Carbon::parse($date))
            ->sum('paid');

<<<<<<< HEAD
        $sales = Sale::where('is_deleted', false)->with(['products', 'customer'])
=======
        $sales = Sale::with(['products', 'customer', 'vinyls', 'boards'])
>>>>>>> 7f9bd50 (add notDeletedScope)
            ->when($request->search, function ($query, $search) {
                $query->where('voucher_id', $search);
            }, function ($query) use ($date) {
                $query->whereDate('date', Carbon::parse($date));
            })->latest()->latest()->get();

        //purchase
        $totalPurchaseAmount = Purchase::when(
            $request->search,
            function ($query, $search) {
                $query->where('voucher_id', $search);
            }
        )->whereDate('date', Carbon::parse($date))->latest()->sum('paid');

        $purchases = Purchase::with(['products', 'supplier'])
            ->when($request->search, function ($query, $search) {
                $query->where('voucher_id', $search);
            }, function ($query) use ($date) {
                $query->whereDate('date', Carbon::parse($date));
            })->latest()->get();


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
