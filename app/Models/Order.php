<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';

    public function menu() {
        return $this->belongsToMany(Menu::class, 'order_details', 'orderid', 'menuid')->withPivot('unit_quantity', 'subtotal', 'menu_status');
    }

    public function type() {
        
    }
}
