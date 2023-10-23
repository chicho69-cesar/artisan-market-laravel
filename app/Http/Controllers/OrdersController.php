<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

  public function get_order(Request $request, string $id): JsonResponse {
    $order = Order::find($id);

    if (!$order) {
      return $this->send_error('Order not found');
    }

    $order->load('order_products');
    $order->load('products');
    $order->load('address');
    $order->load('user');

    return $this->send_response($order, 'Order retrieved successfully.');
  }

  public function get_user_orders(Request $request): JsonResponse {
    $user = $request->user();

    $orders = Order::where('user_id', $user->id)->get();

    $orders->load('order_products');
    $orders->load('products');
    $orders->load('address');
    $orders->load('user');

    return $this->send_response($orders, 'Orders retrieved successfully.');
  }

  public function get_seller_orders(Request $request): JsonResponse {
    $user = $request->user();
    $user->load('role');

    if ($user->role->name != 'seller') {
      return $this->send_error('User is not a seller');
    }

    $my_products = Product::where('seller_id', $user->id)->get();
    $order_products = OrderProduct::whereIn('product_id', $my_products->pluck('id'))->get();
    $order_ids = $order_products->pluck('order_id')->unique()->toArray();
    $orders = Order::whereIn('id', $order_ids)->with('address', 'order_products.product')->get();

    $filtered_orders = [];

    foreach ($orders as $order) {
      $subtotal = 0;

      foreach ($order->order_products as $order_product) {
        if ($order_product->product->seller_id === $user->id) {
          $product_subtotal = $order_product->product->price * $order_product->quantity;
          $subtotal += $product_subtotal;
        }
      }

      $filtered_order = [
        'address' => $order->address,
        'order_id' => $order->id,
        'order_status' => $order->status,
        'order_date' => $order->date,
        'subtotal' => $subtotal,
        'tax' => $subtotal * 0.16,
        'total' => $subtotal * 1.16,
        'products' => $order->order_products->filter(function ($order_product) use ($user) {
          return $order_product->product->seller_id === $user->id;
        })->map(function ($order_product) {
          return [
            'product' => $order_product->product,
            'quantity_sold' => $order_product->quantity,
          ];
        })->values()->all(),
      ];

      $filtered_orders[] = $filtered_order;
    }

    return $this->send_response($filtered_orders, 'Orders retrieved successfully.');
  }

  public function pay_order(Request $request, string $id): JsonResponse {
    $user = $request->user();
    $order = Order::find($id);

    if (!$order) {
      return $this->send_error('Order not found');
    }

    if ($order->user_id != $user->id) {
      return $this->send_error('Order does not belong to user');
    }

    $order->status = 'paid';
    $order->save();

    $order->load('order_products');
    $order->load('products');
    $order->load('address');
    $order->load('user');

    return $this->send_response($order, 'Order paid successfully.');
  }

  // cancel order
}
