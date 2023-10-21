<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends ResponseController {
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

  public function get_product(Request $request, string $id): JsonResponse {
    $product = Product::find($id);

    if (!$product) {
      return $this->send_error('Product not found.', ['error' => 'Product not found.']);
    }

    $product->load('seller');
    $product->load('images');
    $product->load('categories');

    return $this->send_response($product, 'Product retrieved successfully.');
  }

  public function get_products(Request $request): JsonResponse {
    $products = Product::paginate(10);

    $products->load('seller');
    $products->load('images');
    $products->load('categories');

    return $this->send_response($products, 'Products retrieved successfully.');
  }

  // search products

  // get products of a seller

  // update product

  // delete product

  public function upload_image(Request $request, string $id): JsonResponse {
    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $path = $file->store('product_images', 'public');

      $productImage = Image::create([
        'link' => $path,
        'product_id' => $id,
      ]);
      $productImage->save();

      return $this->send_response(['image' => $productImage->link], 'Product image uploaded successfully.');
    }

    return $this->send_error('No file uploaded.', ['error' => 'No file uploaded.']);
  }

  public function delete_image(string $id): JsonResponse {
    $image = Image::find($id);

    if (!$image) {
      return $this->send_error('Image not found.', ['error' => 'Image not found.']);
    }

    Storage::disk('public')->delete($image->link);
    $image->delete();

    return $this->send_response([], 'Image deleted successfully.');
  }
}