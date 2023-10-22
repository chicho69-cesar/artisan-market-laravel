<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressesController extends ResponseController {
  public function create_address(Request $request): JsonResponse {
    $body = $request->all();

    $validator = Validator::make($body, [
      'street' => 'required|string',
      'no_out' => 'required|string',
      'no_in' => 'required|string',
      'zip_code' => 'required|string',
      'city' => 'required|string',
      'state' => 'required|string',
      'country' => 'required|string',
      'phone' => 'required|string|max:20',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $address = Address::create([
      'street' => $body['street'],
      'no_out' => $body['no_out'],
      'no_in' => $body['no_in'],
      'zip_code' => $body['zip_code'],
      'city' => $body['city'],
      'state' => $body['state'],
      'country' => $body['country'],
      'phone' => $body['phone'],
    ]);
    $address->save();

    return $this->send_response($address, 'Address added successfully.');
  }

  public function update_address(Request $request, string $id): JsonResponse {
    $body = $request->all();
    $address = Address::find($id);

    if (!$address) {
      return $this->send_error('Address not found');
    }

    $validator = Validator::make($body, [
      'street' => 'required|string',
      'no_out' => 'required|string',
      'no_in' => 'required|string',
      'zip_code' => 'required|string',
      'city' => 'required|string',
      'state' => 'required|string',
      'country' => 'required|string',
      'phone' => 'required|string|max:20',
    ]);

    if ($validator->fails()) {
      return $this->send_error('Validation Error', $validator->errors());
    }

    $address->street = $body['street'];
    $address->no_out = $body['no_out'];
    $address->no_in = $body['no_in'];
    $address->zip_code = $body['zip_code'];
    $address->city = $body['city'];
    $address->state = $body['state'];
    $address->country = $body['country'];
    $address->phone = $body['phone'];
    $address->save();

    return $this->send_response($address, 'Address updated successfully.');
  }
}
