<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category_product;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'product_images', 'comments', 'feedback'];

    public function images()
    {
        return $this->hasMany(Images::class, 'product_id'); 
    }

   
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products', 'product_id', 'category_id')->withTimestamps();
      
    }
}
