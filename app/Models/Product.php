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

  public function product_categories(): HasMany {
    return $this->hasMany(ProductCategory::class);
  }

  public function reviews(): HasMany {
    return $this->hasMany(Review::class);
  }
}
