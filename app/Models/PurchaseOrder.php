<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductUom;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchase_order';
    protected $guarded = [];  
    
}
