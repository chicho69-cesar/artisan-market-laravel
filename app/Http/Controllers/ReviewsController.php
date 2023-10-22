<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewsController extends ResponseController {
  public function create_review(Request $request, string $product_id): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $validator = Validator::make($body, [
      'rate' => 'required|numeric|min:0|max:5',
      'comment' => 'required|string',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $review = Review::create([
      'product_id' => $product_id,
      'user_id' => $user->id,
      'rate' => $body['rate'],
      'comment' => $body['comment'],
    ]);
    $review->save();

    return $this->send_response($review, 'Review added successfully.');
  }

  public function get_review(Request $request, string $id): JsonResponse {
    $review = Review::find($id);

    if (!$review) {
      return $this->send_error('Review not found');
    }

    $review->load('user');

    return $this->send_response($review, 'Review found successfully.');
  }

  // get all reviews of a product

  // update a review

  // delete a review
}
