<?php

namespace App\DataTables;

use DataTables;

class OrderDatatable extends DataTables
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
            $view = '<a class="btn btn-primary" href="'. route('admin.orders.show',$data->id).'"  title="View">View</a>';
            return $view;
        })
        ->addColumn('user_name', function ($data) {
            return $data->user->name;
        })
        ->editColumn('created_at', function ($data) {
            return date('d-m-Y',strtotime($data->created_at));
        })
        ->rawColumns(['action','user_name','created_at']);
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
