<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
    /**
     * busca os produtos da tag
     */
    public function Products()
    {
        return $this->belongsToMany('App\Product');
    }

    public function scopeOfTag($query, $id){
        return $query->where('id', '=', $id);
    }


}
