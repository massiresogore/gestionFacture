<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invoice
 */
class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'number',
        'date',
        'due_date',
        'term_and_conditions',
        'discount',
        'total',
        'user_id',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceProduct(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return  $this->hasMany(InvoiceProduct::class);
    }

    public function deleteInvoiceProduct(): void
    {
        $this->invoiceProduct()->delete();
    }
}
