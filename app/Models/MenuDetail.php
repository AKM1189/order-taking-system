<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuDetail extends Model
{
    use HasFactory;

    protected $table = 'menu_details';
    protected $fillable = ['id', 'purchase_id', 'menu_id', 'price', 'quantity', 'subtotal'];
}
