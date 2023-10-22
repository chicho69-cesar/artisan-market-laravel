<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends ResponseController {
  public function create_order(Request $request): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $validator = Validator::make($body, [
      'address_id' => 'required|exists:addresses,id',
      'products' => 'required|array',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $subtotal = 0;
    $tax_rate = 0.16;

    foreach ($body['products'] as $product) {
      $product_in_db = Product::find($product['id']);

      if (!$product_in_db) {
        return $this->send_error('Product with id ' . $product['id'] . ' not found');
      }

      if ($product_in_db->stock < $product['quantity']) {
        return $this->send_error('Product with id ' . $product['id'] . ' has insufficient stock');
      }

      $subtotal += $product['quantity'] * $product_in_db->price;
      $product_in_db->stock -= $product['quantity'];
      $product_in_db->save();
    }

    $total = $subtotal + ($subtotal * $tax_rate);

    $order = Order::create([
      'user_id' => $user->id,
      'date' => now(),
      'address_id' => $body['address_id'],
      'status' => 'pending',
      'subtotal' => $subtotal,
      'tax' => $subtotal * $tax_rate,
      'total' => $total,
    ]);
    $order->save();

    foreach ($body['products'] as $product) {
      $order_product = OrderProduct::create([
        'product_id' => $product['id'],
        'order_id' => $order->id,
        'quantity' => $product['quantity'],
      ]);
      $order_product->save();
    }

    $order->load('order_products');
    $order->load('products');
    $order->load('address');
    $order->load('user');

    return $this->send_response($order, 'Order created successfully.');
  }

  // get an order

  // get user orders

  // get seller orders

  // pay order

  // cancel order
}
