<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        // Top 10 selling products with sell quantity.
        $products = Product::addSelect(['sell_quantity'=>
                                OrderDetails::selectRaw('SUM(quantity)')
                                ->whereColumn('product_id', 'products.id')
                                ->limit(1)
                            ])
                            ->orderBy('sell_quantity', 'DESC')
                            ->take(10)
                            ->get()
                            ->whereNotNull('sell_quantity');
        return view('admin.home',compact('products'));
    }
}
