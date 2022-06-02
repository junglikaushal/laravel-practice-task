<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the products with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $products = Product::where('quantity','>','0')->where('status','1')->latest()->paginate(10);
        return view('welcome',compact('products'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
}
