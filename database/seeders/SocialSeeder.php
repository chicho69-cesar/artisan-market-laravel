<?php

namespace Database\Seeders;

use App\Models\Social;
use App\Models\UserSocial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $social = new Social();
    $social->name = 'Facebook';
    $social->save();

    $social = new Social();
    $social->name = 'Twitter';
    $social->save();

    $social = new Social();
    $social->name = 'Linkedin';
    $social->save();

    $social = new Social();
    $social->name = 'Mercado libre';
    $social->save();

    $user_social = new UserSocial();
    $user_social->user_id = 1;
    $user_social->social_id = 1;
    $user_social->link = 'https://www.facebook.com/profile.php?id=100010073019030';
    $user_social->save();

    $user_social = new UserSocial();
    $user_social->user_id = 1;
    $user_social->social_id = 2;
    $user_social->link = 'https://twitter.com/chicho69_cesar';
    $user_social->save();

    $user_social = new UserSocial();
    $user_social->user_id = 1;
    $user_social->social_id = 3;
    $user_social->link = 'https://www.linkedin.com/in/cesarvillalobosolmos';
    $user_social->save();
  }
}
