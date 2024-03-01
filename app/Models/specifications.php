<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specifications extends Model
{
    use HasFactory;
    protected $table = 'product_specifications';
    protected $fillable = ['product_id', 'key', 'value'];

    public $timestamps = false;
}

