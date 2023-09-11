<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceProduct extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id','user_id','product_id','qty','sale_price'];

    public function product (): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user (): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice (): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
