<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
    */
    protected $fillable = [
        'name', 'quantity', 'price', 'image'
    ];

    /**
     * Return product's image full path.
    */
    public function getImageAttribute($value){
        if(isset($value) && $value != '' && $value != null) {
            $path = Storage::disk('public')->exists('product_images/'.$value);
            if($path){
                return url('/').Storage::url('product_images/'.$value);
            }else{
                return url('product_images/default.jpg');
            }
        }else {
            return url('product_images/default.jpg');
        }
    }

    /**
     * Save product's name in capitalize.
    */
    public function setNameAttribute($value){
        $this->attributes['name'] = ucfirst($value);
    }
}
