<?php

namespace App\Http\Controllers\User;

use Auth;
use Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('user.auth:user');
    }

    /**
     * Show the Cart.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $cartData = array();
        $cart = Session::get('cart');
        if($cart){
            foreach($cart as $key => $value){
                $temp = Product::find($key);
                $temp['user_quantity'] = $value;
                array_push($cartData,$temp);
            }
        }
        return view('user.cart',compact('cartData'));
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request)
    {
        $response['status'] = 0;
        $response['msg'] = '';
        $product = Product::find($request->id);
        if($product){
            $cart = Session::get('cart');
            if(isset($cart[$product->id]) && $cart[$product->id] >= 1){
                if(($cart[$product->id] + 1) > $product->quantity){
                    $response['status'] = '2';
                    $response['msg'] = 'Product is out of stock. Please try after sometime';
                }else{
                    $cart[$product->id] = $cart[$product->id] + 1;
                    Session::put('cart', $cart);
                    $response['status'] = '1';
                    $response['msg'] = 'Product added to cart succcessfully ';
                }
            }else{
                $cart[$product->id] = 1;
                Session::put('cart', $cart);
                $response['status'] = '1';
                $response['msg'] = 'Product added to cart succcessfully ';
            }
        }else{
            $response['status'] = '0';
            $response['msg'] = 'Invalid Product';
        }
        return json_encode($response);
    }

    /**
     * Update product quantity in cart.
     */
    public function qtyUpdate(Request $request)
    {
        $response['status'] = 0;
        $response['msg'] = '';
        $cart = Session::get('cart');
        $product = Product::find($request->id);
        if($product){
            if($request->type == 1){
                // Add product quantity
                if(isset($cart[$product->id])){
                    // Check stock
                    if(($cart[$product->id] + 1) > $product->quantity){
                        if($product->quantity == 0){
                            $response['status'] = '2';
                            $response['msg'] = $product->name.' is out of stock. Please try after sometime or remove that product.';
                        }else{
                            $response['status'] = '2';
                            $response['msg'] = 'Only '.$product->quantity.' quantity is available '.$product->name.'.';
                        }
                    }else{
                        $cart[$product->id] = $cart[$product->id] + 1;
                        $response['status'] = '1';
                        $response['msg'] = 'Product added to cart succcessfully ';
                    }
                }else{
                    $cart[$product->id] = 1;
                    $response['status'] = '1';
                    $response['msg'] = 'Product added to cart succcessfully ';
                }
            }else{
                // Remove product quantity
                if(isset($cart[$product->id])){
                    if($cart[$product->id] < 2){
                        unset($cart[$product->id]);
                        $response['status'] = '1';
                        $response['msg'] = 'Product remove from cart succcessfully ';
                    }else{
                        $cart[$product->id] = $cart[$product->id] - 1;
                        $response['status'] = '1';
                        $response['msg'] = 'Product remove from cart succcessfully ';
                    }
                }
            }
            Session::put('cart', $cart);
        }else{
            $response['status'] = '0';
            $response['msg'] = 'Invalid Product';
        }
        return json_encode($response);
    }

    /**
     * Delete product from cart.
     */
    public function deleteFromCart(Request $request)
    {
        $response['status'] = 0;
        $response['msg'] = '';
        $product = Product::find($request->id);
        if($product){
            $cart = Session::get('cart');
            if(isset($cart[$product->id]) && $cart[$product->id] >= 1){
                unset($cart[$product->id]);
                Session::put('cart', $cart);
                $response['status'] = '1';
                $response['msg'] = 'Product removed succcessfully ';
            }
        }else{
            $response['status'] = '0';
            $response['msg'] = 'Invalid Product';
        }
        return json_encode($response);
    }

    /**
     * Check cart products stock.
     */
    public function checkStock(Request $request)
    {
        $response['status'] = 0;
        $response['msg'] = '';
        $cart = Session::get('cart');
        if($cart){
            foreach($cart as $key => $value){
                $temp = Product::find($key);
                if($temp){
                    // Check product stock
                    if($value > $temp->quantity){
                        if($temp->quantity == 0){
                            $response['status'] = '0';
                            $response['msg'] = $temp->name.' is out of stock. Please try after sometime or remove that product.';
                            return json_encode($response);
                        }else{
                            $response['status'] = '0';
                            $response['msg'] = 'Only '.$temp->quantity.' quantity is available '.$temp->name.'.';
                            return json_encode($response);
                        }
                    }else{
                        $response['status'] = '1';
                    }
                }else{
                    $response['status'] = '0';
                    $response['msg'] = 'Invalid Product in cart. Please try after sometimes.';
                    return json_encode($response);
                }
            }
        }
        return json_encode($response);
    }

}
