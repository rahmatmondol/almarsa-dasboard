<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'image',
        'sub_total',
        'cart_id',
        'user_id',
        'discount',
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_id' => 'string',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'cart_id' => 'integer',
        'user_id' => 'integer',
        'discount' => 'decimal:2',
        'name' => 'string',
        'image' => 'string',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

}
