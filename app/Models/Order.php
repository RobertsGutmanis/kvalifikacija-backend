<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $table = 'orders';
    protected $fillable = ['user_id', 'tracking_number', 'created_at', 'delivered_at', 'sum', 'delivery_method'];

    use HasFactory;
}
