<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'order_id', 'product_id', 'price' , 'quantity'
    ];

    /*
    * Get the product record associated with the order details.
    */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id')->withTrashed();
    }
}
