<?php

namespace App\Http\Controllers\Admin;

use Storage;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Datatables\ProductDatatable;
use Yajra\DataTables\Html\Builder;

class ProductController extends Controller
{
    /**
     * Display a listing of the prodcuts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder,ProductDatatable $dataTable)
    {   
        if (request()->ajax()) {
            return $dataTable->dataTable(Product::query())->toJson();
        }
        $html = $builder->columns([
            ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Product Name'],
            ['data' => 'quantity', 'name' => 'quantity', 'title' => 'Product Quantity'],
            ['data' => 'price', 'name' => 'price', 'title' => 'Product Price'],
            ['data' => 'image', 'name' => 'image', 'title' => 'Product Image','orderable' => false, 'searchable' => false,'class'=>'text-center'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Product Status','class'=>'text-center'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action','orderable' => false, 'searchable' => false,'class'=>'text-center']
        ]);
        return view('admin.product.index',compact('html'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
    }

    /**
     * Store a newly created product in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]);
        $data = $request->all();
        if(!empty($request['image']) || $request['image'] != null){
            $fileName = md5(microtime() . $request->file('image')->getClientOriginalName()) . "." . $request->file('image')->clientExtension();
            $path = Storage::disk('public')->putFileAs('product_images', $request->file('image'), $fileName, 'public');
            $data['image'] = $fileName;
        }
        Product::create($data);
        return redirect()->route('admin.products.index')->with('success','Product created successfully.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit',compact('product'));
    }

    /**
     * Update the specified product in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);
        $data = $request->all();
        if(!empty($request['image']) || $request['image'] != null){
            // Remove old image
            if($product->getOriginal('image') != null && Storage::disk('public')->exists('product_images/'.$product->getOriginal('image'))){
                Storage::disk('public')->delete('product_images/'.$product->getOriginal('image'));
            }
            $fileName = md5(microtime() . $request->file('image')->getClientOriginalName()) . "." . $request->file('image')->clientExtension();
            $path = Storage::disk('public')->putFileAs('product_images', $request->file('image'), $fileName, 'public');
            $data['image'] = $fileName;
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified product from database.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }

    /**
     * Change the specified product status from database.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function changeStatus(Request $request)
    {
        if(isset(($request->id))){
            $record = Product::find($request->id);
            $result = "";
            if(isset($record)){
                if($record->status == 0){
                    $record->status= '1';
                    $result ="Active";
                }else {
                    $record->status= '0';
                    $result ="Deactive";
                }
                $record->save();
                return $result;
            }else{
                return 'error';
            }
        }
    }
}
