<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'total'
    ];

    /**
     * 📦 Uma venda tem vários itens
     */
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * 🔗 Acesso direto aos produtos através dos itens da venda
     * (relação indireta: Sale -> SaleItem -> Product)
     */
    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            SaleItem::class,
            'sale_id',     // FK em sale_items
            'id',          // PK em products
            'id',          // PK em sales
            'product_id'   // FK em sale_items
        );
    }
}