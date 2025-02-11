<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'status',
        'sub_total',
        'discount',
        'grand_total',
        'count',
        'status',
        'shipping_method',
        'shipping_cost',
        'payment_method',
        'payment_reference',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_address2',
        'shipping_city',
        'shipping_country',
        'shipping_state',
        'shipping_postal_code',
        'shipping_phone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'status' => 'string',
        'sub_total' => 'decimal:2',
        'discount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'count' => 'integer',
        'shipping_method' => 'string',
        'shipping_cost' => 'decimal:2',
        'payment_method' => 'string',
        'payment_reference' => 'string',
        'shipping_first_name' => 'string',
        'shipping_last_name' => 'string',
        'shipping_address' => 'string',
        'shipping_address2' => 'string',
        'shipping_city' => 'string',
        'shipping_country' => 'string',
        'shipping_state' => 'string',
        'shipping_postal_code' => 'string',
        'shipping_phone' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
