<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\RawMaterial;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_no','purchase_date','description', 'total', 'paid_amount', 'balance', 'payment_type', 'supplier_id'];

    public function menu(){
        return $this->belongsToMany(Menu::class, 'menu_details', 'purchase_id', 'menu_id')->withPivot('price', 'quantity', 'subtotal');
    }

    public function rawMaterial(){
        return $this->belongsToMany(RawMaterial::class, 'purchase_details', 'purchase_id', 'material_id')->withPivot('price', 'quantity', 'subtotal');
    }
}
