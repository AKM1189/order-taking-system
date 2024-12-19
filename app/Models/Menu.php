<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RawMaterial;
use App\Models\Purchase;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function rawMaterial(){
        return $this->belongsToMany(RawMaterial::class, 'raw_material_details', 'menuid', 'itemid')
        ->withPivot('quantity', 'subtotal');
    }

    public function purchase(){
        return $this->belongsToMany(Purchase::class, 'menu_details', 'purchase_id', 'menu_id')->withPivot('price', 'quantity', 'subtotal');
    }
}
