<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category_product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'product_id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id')->withTimestamps();
       
    
    }
}
