<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InvoiceProduct

 */
class InvoiceProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        "product_id",
        "invoice_id",
        "quantity",
        "unit_price",
    ];
}
