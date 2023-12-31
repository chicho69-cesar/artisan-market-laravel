<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Social extends Model {
  use HasFactory;

  protected $fillable = [
    'name',
  ];

  public function user_social(): HasMany {
    return $this->hasMany(UserSocial::class);
  }

  public function users() {
    return $this->hasManyThrough(User::class, UserSocial::class, 'user_id', 'id', 'id', 'social_id');
  }
}
