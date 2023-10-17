<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model {
  use HasFactory;

  protected $fillable = [
    'user_send_id',
    'user_receive_id',
    'message',
    'date',
  ];

  public function user_send(): BelongsTo {
    return $this->belongsTo(User::class, 'user_send_id');
  }

  public function user_receive(): BelongsTo {
    return $this->belongsTo(User::class, 'user_receive_id');
  }
}
