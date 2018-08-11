<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'extension'
    ];

    public function product(){
        return $this->belongsTo('App\Product');
    }
}
