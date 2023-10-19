<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSocial extends Model {
  use HasFactory;

  protected $fillable = [
    'user_id',
    'social_id',
    'link',
  ];

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function social(): BelongsTo {
    return $this->belongsTo(Social::class);
  }
}
