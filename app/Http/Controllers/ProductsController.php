<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends ResponseController {
  // create product
  public function create(Request $request): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $validator = Validator::make($body, [
      'name' => 'required|string|max:255',
      'description' => 'required|string',
      'price' => 'required|numeric|gte:0',
      'stock' => 'required|numeric|gte:0',
      'categories' => 'required|array',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $product = Product::create([
      'name' => $body['name'],
      'description' => $body['description'],
      'price' => $body['price'],
      'stock' => $body['stock'],
      'seller_id' => $user->id,
    ]);
    $product->save();

    foreach ($body['categories'] as $category) {
      $category = Category::firstOrNew(['name' => $category]);
      $category->save();

      $productCategory = ProductCategory::create([
        'product_id' => $product->id,
        'category_id' => $category->id,
      ]);
      $productCategory->save();
    }

    return $this->send_response(
      [
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'stock' => $product->stock,
        'categories' => $body['categories'],
        'seller' => $user,
      ],
      'Product created successfully.',
      201
    );
  }

  // get a product

  // get a list of products with pagination

  // search products

  // get products of a seller

  // update product

  // delete product
}
