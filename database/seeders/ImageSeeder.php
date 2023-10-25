<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $image = new Image();
    $image->link = 'product_images/baul.jpg';
    $image->product_id = 1;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/blusa-1.jpg';
    $image->product_id = 2;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/blusa-2.jpg';
    $image->product_id = 2;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/blusa-3.jpg';
    $image->product_id = 2;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/figura-1.jpg';
    $image->product_id = 3;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/figura-2.jpg';
    $image->product_id = 3;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/gato-de-tela.jpg';
    $image->product_id = 4;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/interior-1.jpg';
    $image->product_id = 5;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/interior-2.jpg';
    $image->product_id = 5;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/interior-3.jpg';
    $image->product_id = 5;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/licor-de-jamaica.jpg';
    $image->product_id = 6;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/mochila.jpg';
    $image->product_id = 7;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/tasas.jpg';
    $image->product_id = 8;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/vestido-artesanal-1.jpg';
    $image->product_id = 9;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/vestido-artesanal-2.jpg';
    $image->product_id = 9;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/vestido-artesanal-3.jpg';
    $image->product_id = 9;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/vestido-artesanal-4.jpg';
    $image->product_id = 9;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/vestido-artesanal-5.jpg';
    $image->product_id = 9;
    $image->save();

    $image = new Image();
    $image->link = 'product_images/vestido-artesanal-6.jpg';
    $image->product_id = 9;
    $image->save();
  }
}
