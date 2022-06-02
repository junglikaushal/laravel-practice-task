<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'user_id', 'total_amount'
    ];

    /*
    * Get the user record associated with the order.
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /*
    * Get the products record associated with the order.
    */
    public function order_details()
    {
        return $this->hasMany('App\Models\OrderDetails','order_id', 'id');
    }
}
