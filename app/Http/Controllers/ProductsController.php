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

    $product->load('seller');
    $product->load('images');
    $product->load('categories');

    return $this->send_response($product, 'Product created successfully.', 201);
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

  public function search_products(Request $request): JsonResponse {
    $products = Product::where('name', 'like', '%' . $request->query('q') . '%')
      ->orWhere('description', 'like', '%' . $request->query('q') . '%')
      ->paginate(20);

    $products->load('seller');
    $products->load('images');
    $products->load('categories');

    return $this->send_response($products, 'Products retrieved successfully.');
  }

  public function get_seller_products(Request $request): JsonResponse {
    $user = $request->user();
    $products = Product::where('seller_id', $user->id)->paginate(20);

    $products->load('seller');
    $products->load('images');
    $products->load('categories');

    return $this->send_response($products, 'Products retrieved successfully.');
  }

  public function update_product(Request $request, string $id): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $product_to_update = Product::find($id);

    if (!$product_to_update) {
      return $this->send_error('Product not found.', ['error' => 'Product not found.']);
    }

    if ($product_to_update->seller_id != $user->id) {
      return $this->send_error('Unauthorized.', ['error' => 'Unauthorized.']);
    }

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

    $product_to_update->name = $body['name'];
    $product_to_update->description = $body['description'];
    $product_to_update->price = $body['price'];
    $product_to_update->stock = $body['stock'];

    $product_categories = ProductCategory::where('product_id', $id)->get();

    foreach ($product_categories as $category) {
      $category->delete();
    }

    foreach ($body['categories'] as $category) {
      $category = Category::firstOrNew(['name' => $category]);
      $category->save();

      $productCategory = ProductCategory::create([
        'product_id' => $id,
        'category_id' => $category->id,
      ]);
      $productCategory->save();
    }

    $product_to_update->save();

    $product_to_update->load('seller');
    $product_to_update->load('images');
    $product_to_update->load('categories');

    return $this->send_response($product_to_update, 'Product updated successfully.');
  }

  public function delete_product(Request $request, string $id): JsonResponse {
    $user = $request->user();
    $product_to_delete = Product::find($id);

    if (!$product_to_delete) {
      return $this->send_error('Product not found.', ['error' => 'Product not found.']);
    }

    if ($product_to_delete->seller_id != $user->id) {
      return $this->send_error('Unauthorized.', ['error' => 'Unauthorized.']);
    }

    $product_categories = ProductCategory::where('product_id', $id)->get();

    foreach ($product_categories as $category) {
      $category->delete();
    }

    $product_to_delete->delete();

    return $this->send_response([], 'Product deleted successfully.');
  }

  public function upload_image(Request $request, string $id): JsonResponse {
    if ($request->hasFile('image')) {
      $file = $request->file('image');
      $path = $file->store('product_images', 'public');

      $product_image = Image::create([
        'link' => $path,
        'product_id' => $id,
      ]);
      $product_image->save();

      return $this->send_response(['image' => $product_image->link], 'Product image uploaded successfully.');
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
