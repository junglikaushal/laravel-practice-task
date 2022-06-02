<?php

namespace App\Http\Controllers\User;

use Auth;
use Session;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Stripe\StripeClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display strip payment page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $users = $stripe->customers->all();
        $strip_user_id = '';
        foreach($users->data as $value){
            if($value['email'] == Auth::guard('user')->user()->email){
                $strip_user_id = $value['id'];
            }
        }
        if($strip_user_id == ''){
            $user = $stripe->customers->create([
                'name' => Auth::guard('user')->user()->name,
                'email' => Auth::guard('user')->user()->email,
            ]);
            $strip_user_id = $user->id;
        }
        $data = $stripe->setupIntents->create([
            'customer' => $strip_user_id,
            'payment_method_types' => ['card'],
        ]);
        return view('user.payment',compact('data'));
    }

    /**
     * Store user card.
     *
     * @return \Illuminate\Http\Response
     */
    public function setupComplete(Request $request)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $data = $stripe->setupIntents->retrieve($request->setup_intent,[]);
        if($data->status == 'succeeded'){
            return redirect()->route('user.checkOut');
        }else{
            Session::flash('message', 'Something went wrong please try after sometime.');
            Session::flash('alert-class', 'error');
            return redirect()->route('user.cart');
        }
    }

    /**
     * Store a user order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkOut(Request $request)
    {   
        $order_data = array();
        $cart = Session::get('cart');
        $total_price = 0;
        if($cart){
            foreach($cart as $key => $value){
                $temp = Product::find($key);
                if($temp){
                    if($value > $temp->quantity){
                        if($temp->quantity == 0){
                            Session::flash('message', $temp->name.' is out of stock. Please try after sometime or remove that product.');
                            Session::flash('alert-class', 'error');
                            return redirect()->route('user.cart');
                        }else{
                            Session::flash('message', 'Only '.$temp->quantity.' quantity is available '.$temp->name.'.');
                            Session::flash('alert-class', 'error');
                            return redirect()->route('user.cart');
                        }
                    }else{
                        $total_price = $total_price + ($temp->price * $value);
                        $order_data[$key]['product_id'] = $temp->id;
                        $order_data[$key]['price'] = $temp->price;
                        $order_data[$key]['quantity'] = $value;
                    }
                }else{
                    Session::flash('message', 'Invalid Product in cart. Please try after sometimes.');
                    Session::flash('alert-class', 'error');
                    return redirect()->route('user.cart');
                }
            }
        }
        $order = Order::create(['user_id'=>Auth::guard('user')->user()->id,'total_amount'=>$total_price]);
        foreach($order_data as $product){
            $updateStock = Product::where('id',$product['product_id'])->first();
            $updateStock->update([
                'quantity' => ($updateStock->quantity - $product['quantity']), // quantity of product from order
            ]);
            OrderDetails::create([
                'order_id'=>$order->id,
                'product_id'=>$product['product_id'],
                'price'=>$product['price'],
                'quantity'=>$product['quantity'],
            ]);
        }
        Session::put('cart', array());
        Session::flash('message', 'Order created successfully.');
        Session::flash('alert-class', 'success');
        return redirect()->route('user.home');
    }

}
