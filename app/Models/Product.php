<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description','price', 'quantity', 'image', 'category_id','status'];
   protected $table = 'products';
   protected $primaryKey = 'product_id';

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
