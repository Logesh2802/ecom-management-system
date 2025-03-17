<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $fillable = ['name', 'description'];
   protected $table = 'categories';
   protected $primaryKey = 'category_id';

   public $timestamps = false;
    public function products() {
        return $this->hasMany(Product::class);
    }
}
