<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'price',
    'stock',
    'seller_id',
  ];

  public function seller(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function images(): HasMany {
    return $this->hasMany(Image::class);
  }

  public function categories() {
    return $this->hasManyThrough(Category::class, ProductCategory::class, 'product_id', 'id', 'id', 'category_id');
  }

  public function reviews(): HasMany {
    return $this->hasMany(Review::class);
  }

  public function order_products(): HasMany {
    return $this->hasMany(OrderProduct::class);
  }
}
