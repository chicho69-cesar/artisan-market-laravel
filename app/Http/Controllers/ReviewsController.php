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

  public function get_reviews(Request $request, string $product_id): JsonResponse {
    $reviews = Review::where('product_id', $product_id)->get();
    $reviews->load('user');

    return $this->send_response($reviews, 'Reviews found successfully.');
  }

  public function update_review(Request $request, string $id): JsonResponse {
    $body = $request->all();
    $user = $request->user();

    $review = Review::find($id);

    if (!$review) {
      return $this->send_error('Review not found');
    }

    if ($review->user_id != $user->id) {
      return $this->send_error('You are not authorized to update this review.');
    }

    $validator = Validator::make($body, [
      'rate' => 'required|numeric|min:0|max:5',
      'comment' => 'required|string',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $review->rate = $body['rate'];
    $review->comment = $body['comment'];
    $review->save();

    $review->load('user');

    return $this->send_response($review, 'Review updated successfully.');
  }

  public function delete_review(Request $request, string $id): JsonResponse {
    $user = $request->user();
    $review = Review::find($id);

    if (!$review) {
      return $this->send_error('Review not found');
    }

    if ($review->user_id != $user->id) {
      return $this->send_error('You are not authorized to delete this review.');
    }

    $review->delete();

    return $this->send_response([], 'Review deleted successfully.');
  }
}
