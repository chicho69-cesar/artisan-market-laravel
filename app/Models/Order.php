<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model {
  use HasFactory;

  protected $fillable = [
    'user_id',
    'date',
    'address_id',
    'status',
    'subtotal',
    'tax',
    'total',
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function address(): BelongsTo {
    return $this->belongsTo(Address::class);
  }

  public function order_products(): HasMany {
    return $this->hasMany(OrderProduct::class);
  }

  public function products() {
    return $this->hasManyThrough(Product::class, OrderProduct::class, 'order_id', 'id', 'id', 'product_id');
  }
}
