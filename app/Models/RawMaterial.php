<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\Purchase;

class RawMaterial extends Model
{
    use HasFactory;

    public function menu(){
        return $this->belongsToMany(Menu::class, 'raw_material_details', 'menuid', 'itemid')->withPivot('quantity', 'subtotal');
    }

    public function purchase(){
        return $this->belongsToMany(Purchase::class, 'purchase_details', 'purchase_id', 'material_id')->withPivot('price', 'quantity', 'subtotal');
    }
}
