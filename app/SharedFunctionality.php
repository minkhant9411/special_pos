<?php

namespace App;

use App\Models\Category;
use App\Models\Product;

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
}
