<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'lastname',
    'email',
    'password',
    'role_id',
    'picture',
    'biography',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function role(): BelongsTo {
    return $this->belongsTo(Role::class);
  }

  public function user_social(): HasMany {
    return $this->hasMany(UserSocial::class);
  }

  public function socials() {
    return $this->hasManyThrough(Social::class, UserSocial::class, 'user_id', 'id', 'id', 'social_id');
  }

  public function followers(): HasMany {
    return $this->hasMany(Follower::class);
  }

  public function followings(): HasMany {
    return $this->hasMany(Follower::class);
  }

  public function messages_send(): HasMany {
    return $this->hasMany(Message::class, 'user_send_id');
  }

  public function messages_received(): HasMany {
    return $this->hasMany(Message::class, 'user_receive_id');
  }

  public function products(): HasMany {
    return $this->hasMany(Product::class);
  }

  public function reviews(): HasMany {
    return $this->hasMany(Review::class);
  }
}
