<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','stock','price','category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\Category');
    }
}
