<?php

namespace App\Http\Controllers;

use App\SharedFunctionality;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    use SharedFunctionality;
    public function home(Request $request)
    {
        $data = $this->getData($request);
        return Inertia('Home', [
            'totalSaleAmount' => $data->totalSaleAmount,
            'totalPurchaseAmount' => $data->totalPurchaseAmount
        ]);
    }
}
