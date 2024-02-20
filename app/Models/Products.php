<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'manufacturer', 'price', 'last_price', 'category_id', 'image_url'];

    public $timestamps = false;

    use HasFactory;
}
