<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','thumbnail','is_active'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'role_user');

    }

}
