<?php

namespace App\DataTables;

use DataTables;

class ProductDatatable extends DataTables
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addColumn('action', function ($data) {
            // Product View
            $view = '<a class="btn btn-primary" href="'. route('admin.products.show',$data->id).'"  title="View">View</a>';
            // Product Edit
            $edit = '<a class="btn btn-success" href="' . route('admin.products.edit',$data->id) . '"  title="Update">Update</a>';
            // Product Delete
            $delete = '<a class="btn btn-danger" href="javascript:;"  title="Delete" onclick="deleteConfirm('.$data->id.')">Delete</a>';
            return $view.' '.$edit.' '.$delete.' ';
        })
        ->addColumn('status',  function($data) {
            $id = $data->id;
            $class='text-danger';
            $label='Inactive';
            if($data->status==1){
                $class='text-success';
                $label='Active';
            }
            return  '<span class="text-wrap user-select-none '.$class.' actStatus" id = "user'.$id.'" data-sid="'.$id.'">'.$label.'</span>';
        })
        ->editColumn('image',  function($data) {
            return '<img src="'.$data->image.'" alt="'.$data->name.'" width="50" height="50">';
        })
        ->rawColumns(['action','status','image']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters($this->getBuilderParameters());
    }
}
