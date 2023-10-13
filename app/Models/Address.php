<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Address extends Model {
  use HasFactory;

  protected $fillable = [
    'street',
    'no_out',
    'no_in',
    'zip_code',
    'city',
    'state',
    'country',
    'phone',
  ];

  public function order(): HasOne {
    return $this->hasOne(Order::class);
  }
}
