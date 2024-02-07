<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "description",
        "unit_price"
    ];
}
