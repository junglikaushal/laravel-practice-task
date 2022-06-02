<?php

namespace App\Http\Controllers\User;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with pagination in user homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $products = Product::where('quantity','>','0')->where('status','1')->latest()->paginate(10);
        return view('user.home',compact('products'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
