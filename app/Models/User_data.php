<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_data extends Model
{
    public $timestamps = false;
    protected $table = 'user_data';
    protected $fillable = ['name', 'user_id', 'middle_name', 'last_name'];

    use HasFactory;
}
