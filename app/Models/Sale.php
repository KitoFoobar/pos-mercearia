<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'total',
        'received',
        'change'
    ];

    /**
     * 📦 Uma venda tem vários itens
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * 🔗 acesso indireto a produtos
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            SaleItem::class,
            'sale_id',
            'id',
            'id',
            'product_id'
        );
    }
}