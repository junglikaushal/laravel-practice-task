<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\OrderDatatable;
use Yajra\DataTables\Html\Builder;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder,OrderDatatable $dataTable)
    {   
        if (request()->ajax()) {
            return $dataTable->dataTable(Order::get())->toJson();
        }
        $html = $builder->columns([
            ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
            ['data' => 'user_name', 'name' => 'user_name', 'title' => 'User Name'],
            ['data' => 'total_amount', 'name' => 'total_amount', 'title' => 'Total Amount'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Order Date'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action','orderable' => false, 'searchable' => false,'class'=>'text-center']
        ]);
        return view('admin.order.index',compact('html'));
    }

    /**
     * Display the specified order details.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.order.show',compact('order'));
    }

}
