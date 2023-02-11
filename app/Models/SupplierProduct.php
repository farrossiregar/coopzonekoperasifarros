<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductUom;

class SupplierProduct extends Model
{
    use HasFactory;
    protected $table = 'supplier_product';
    protected $guarded = [];  
   
}
