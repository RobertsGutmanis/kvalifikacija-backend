<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class specifications extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'product_specifications';
    protected $fillable = ['product_id', 'key', 'value'];
}

