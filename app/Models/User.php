<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['firstName','lastName','email','mobile','password','otp'];

    protected $attributes = [
        'otp' => '0'
    ];

    public function categories (): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function customers (): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function products (): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function invoices (): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoiceProduct (): HasMany
    {
        return $this->hasMany(InvoiceProduct::class);
    }

}
