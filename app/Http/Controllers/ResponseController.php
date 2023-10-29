<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller {
  public function send_response($result, $message, $code = 200) {
    $response = [
      'success' => true,
      'data' => $result,
      'message' => $message,
    ];

    return response()->json($response, $code);
  }

  public function send_error($error, $messages = [], $code = 404) {
    $response = [
      'success' => false,
      'message' => $error,
    ];

    if (!empty($messages)) {
      $response['data'] = $messages;
    }

    return response()->json($response, $code);
  }

  public function token() {
    return csrf_token();
  }
}
