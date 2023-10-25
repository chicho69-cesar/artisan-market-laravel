<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $seller = new User();
    $seller->name = 'Cesar';
    $seller->lastname = 'Villalobos Olmos';
    $seller->email = 'cesarvillalobosolmos.01@gmail.com';
    $seller->password = Hash::make('password');
    $seller->role_id = 1;
    $seller->picture = 'profile_pictures/iNEvPpVgc4jUCzHv8thJ17gC6EPUhx3MeYBtrwB3.jpg';
    $seller->save();

    $user = new User();
    $user->name = 'Lizeth';
    $user->lastname = 'Sandoval Vallejo';
    $user->email = 'chamita69.liz@gmail.com';
    $user->password = Hash::make('password');
    $user->role_id = 2;
    $user->save();
  }
}
