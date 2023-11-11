<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends ResponseController {
  public function get_dashboard_stats(Request $request): JsonResponse {
    $user = $request->user();
    $user->load('role');

    if ($user->role->name != 'seller') {
      return $this->send_error('User is not a seller');
    }

    // Obtener productos del vendedor
    $my_products = Product::where('seller_id', $user->id)->get();
    // Obtener productos con stock igual a 0
    $zero_stock_products = $my_products->where('stock', 0)->count();
    // Obtener todas las ordenes que incluyen productos del vendedor
    $order_products = OrderProduct::whereIn('product_id', $my_products->pluck('id'))->get();
    // Obtener los IDs únicos de las ordenes
    $order_ids = $order_products->pluck('order_id')->unique()->toArray();
    // Obtener las ordenes con sus productos
    $orders = Order::whereIn('id', $order_ids)->with('order_products.product')->get();

    // Inicializar contadores
    $paid_orders_count = 0;
    $pending_orders_count = 0;
    $cancelled_orders_count = 0;
    $total_reviews = 0;

    $filtered_orders = [];

    foreach ($orders as $order) {
      // Contar el estado de las ordenes
      switch ($order->status) {
        case 'paid':
          $paid_orders_count++;
          break;
        case 'pending':
          $pending_orders_count++;
          break;
        case 'cancelled':
          $cancelled_orders_count++;
          break;
      }

      $filtered_order = [
        'order_id' => $order->id,
      ];

      $filtered_orders[] = $filtered_order;
    }

    // Obtener el número de reviews para los productos de este vendedor
    $total_reviews += Review::whereIn('product_id', $my_products->pluck('id'))->count();

    // Crear un array con las estadísticas
    $stats = [
      'total_orders' => count($filtered_orders),
      'paid_orders' => $paid_orders_count,
      'pending_orders' => $pending_orders_count,
      'cancelled_orders' => $cancelled_orders_count,
      'total_products' => count($my_products),
      'zero_stock_products' => $zero_stock_products,
      'total_reviews' => $total_reviews,
    ];

    return $this->send_response(['stats' => $stats], 'Order stats retrieved successfully.');
  }
}
