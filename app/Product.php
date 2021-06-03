<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $fillable = ['title','description','images','is_avaliable','price','trending'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }
}
