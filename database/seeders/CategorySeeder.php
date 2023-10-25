<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    $category = new Category();
    $category->name = 'artesanal';
    $category->save();

    $category = new Category();
    $category->name = 'colorido';
    $category->save();

    $category = new Category();
    $category->name = 'unisex';
    $category->save();

    $category = new Category();
    $category->name = 'manualidades';
    $category->save();

    $category = new Category();
    $category->name = 'ropa';
    $category->save();

    $category = new Category();
    $category->name = 'madera';
    $category->save();

    $category = new Category();
    $category->name = 'regalos';
    $category->save();

    $category = new Category();
    $category->name = 'mujeres';
    $category->save();

    $category = new Category();
    $category->name = 'hombres';
    $category->save();

    $category = new Category();
    $category->name = 'tejido';
    $category->save();

    $category = new Category();
    $category->name = 'licor';
    $category->save();

    $category = new Category();
    $category->name = 'trastes';
    $category->save();

    $category = new Category();
    $category->name = 'vestidos';
    $category->save();
  }
}
